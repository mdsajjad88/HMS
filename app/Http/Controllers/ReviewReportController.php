<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use App\Models\DoctorProfile;
use App\Models\MedicalTest;
use App\Models\NutritionistVisit;
use App\Models\PatientProfile;
use App\Models\PatientSubscription;
use App\Models\PatientUser;
use App\Models\PrescribedMedicine;
use App\Models\PrescriptionTherapie;
use App\Models\Problem;
use App\Models\ReviewReport;
use App\Models\Comment;
use App\Models\ReportAndProblem;
use App\Models\ReportAndComment;
use App\Models\User;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user(); // Get the currently authenticated user

            // Check user role and set up query
            if ($user->role === 'admin') {
                $data = ReviewReport::with('problems')->select('review_reports.*')->latest()->get(); // Fetch all doctor profiles
            } elseif ($user->role === 'user') {

                $startOfDay = Carbon::today();
                $endOfDay = Carbon::tomorrow();
                $data = ReviewReport::with('problems')->select('review_reports.*') // Fetch all doctor profiles
                ->whereBetween('created_at', [$startOfDay, $endOfDay])
                    ->orderBy('id', 'DESC') // Records older than 24 hours
                    ->get();
            } else {
                $data = collect(); // Return an empty collection if the role is not recognized
            }


            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn = '<a  data-id="'.$row->id.'"  class="editReport btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i>Edit</a>';
                    $btn .= '<a  data-id="'.$row->id.'" class="deleteReport btn btn-danger btn-sm mt-1"><i class="fa-solid fa-trash"></i>Delete</a>';
                    return $btn;
                })
                ->addColumn('patient_name', function($data) {
                    return $data->patient->username; // Example: Accessing patient's first name
                })
                ->addColumn('doctor_name', function($data) {
                    return $data->doctor->name ?? 'no name'; // Example: Accessing patient's first name
                })
                ->addColumn('problems', function($data) {
                    return $data->problems->pluck('name')->implode(', ');
                })
                ->addColumn('user_name', function($data) {
                    return '<small>'.$data->user->name.'<br>'.
                    $data->created_at->format('Y-m-d') . '<br>' .
                        $data->created_at->format('H:i:s').'</small>';
                })
                ->addColumn('editor_name', function ($data) {
                    if ($data->editor) {
                        return '<small>'.$data->editor->name.'<br>'.
                       $data->updated_at->format('Y-m-d') .'<br>' .
                      $data->updated_at->format('H:i:s')."</small>";
                    }
                    return ' ';
                })
                ->rawColumns(['action','editor_name', 'user_name'])
                ->make(true);

        }


        return view('medical_report.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = PatientProfile::all();
        $doctors = DoctorProfile::all();
        $patient_medical_tests  = MedicalTest::all();
        $prescribed_medicines = PrescribedMedicine::all();
        $prescription_therapies =PrescriptionTherapie::all();
        return view('medical_report.add', compact('patients', 'doctors', 'patient_medical_tests'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Begin the transaction
        DB::beginTransaction();

        try {
            $validatedData = $request->validate([
                'patient_user_id' => 'required',
                'doctor_user_id' => 'required|exists:doctor_profiles,user_id',
                'no_of_visite' => 'required',
                'last_visited_date' => 'required|date',
                'problem_id' => 'nullable|array',
                'problem_id.*' => 'integer',
                'physical_improvement' => 'required',
                'comment' => 'nullable|string',
                'is_session_visite' => 'nullable',
                'session_visite_count' => 'nullable',
                'is_board' => 'nullable',
                'comment_id' => 'required|array',
            ]);

            // Handle boolean flags
            $validatedData['is_session_visite'] = $request->has('is_session_visite') ? 1 : null;
            $isSessionVisite = $validatedData['is_session_visite'];
            $is_board = $validatedData['is_board'] ?? null;

            // Get the patient's mobile number
            $number = PatientProfile::where('patient_user_id', $validatedData['patient_user_id'])->first();

            // Create a new report
            $report = new ReviewReport();
            $report->patient_user_id = $validatedData['patient_user_id'];
            $report->mobile = $number->mobile;
            $report->doctor_user_id = $validatedData['doctor_user_id'];
            $report->created_by = Auth::user()->id;
            $report->no_of_visite = $validatedData['no_of_visite'];
            $report->last_visited_date = $validatedData['last_visited_date'];
            $report->physical_improvement = $validatedData['physical_improvement'];
            $report->comment = $validatedData['comment'];
            $report->is_session_visite = $validatedData['is_session_visite'];

            // Update session_visite_count
            if ($isSessionVisite == 1) {
                $count = $validatedData['session_visite_count'];
                $add = ReviewReport::where('patient_user_id', $validatedData['patient_user_id'])
                    ->where('is_session_visite', 1)
                    ->latest()
                    ->first();

                $report->session_visite_count = $count ?: ($add ? $add->session_visite_count + 1 : 1);
            }

            // Set is_board if applicable
            if (isset($is_board) && $is_board == 1) {
                $report->is_board = 1;
            }

            // Save the report
            $report->save();

            // Attach comments to the report
            foreach ($validatedData['comment_id'] as $commentId) {
                $commentToReport = new ReportAndComment();
                $commentToReport->review_report_id = $report->id;
                $commentToReport->comment_id = $commentId;
                $commentToReport->doctor_user_id = $report->doctor_user_id;
                $commentToReport->patient_user_id = $report->patient_user_id;
                $commentToReport->save();
            }

            // Attach problems to the report
            foreach ($validatedData['problem_id'] as $problemId) {
                $problemToReport = new ReportAndProblem();
                $problemToReport->review_report_id = $report->id;
                $problemToReport->problem_id = $problemId;
                $problemToReport->doctor_user_id = $report->doctor_user_id;
                $problemToReport->last_visited_date = $report->last_visited_date;
                $problemToReport->patient_user_id = $report->patient_user_id;
                $problemToReport->save();
            }

            // Create a nutritionist visit
            $nuVisit = new NutritionistVisit();
            $nuVisit->patient_user_id = $validatedData['patient_user_id'];
            $nuVisit->review_report_id = $report->id;
            $nuVisit->save();

            // Commit the transaction
            DB::commit();

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function creating(Request $request){
        $patients = PatientProfile::all();
        $doctors = DoctorProfile::all();
        $problems = Problem::orderBy('id', 'DESC')->get();
        $comments = Comment::all();

        return view('medical_report.create', compact('patients','doctors', 'problems', 'comments'));
    }
    /**
     * Display the specified resource.
     */
    public function show(ReviewReport $reviewReport)
    {
        //
    }

    public function latestReport($id){

        $today = Carbon::now()->format('Y-m-d');

        $lastVisitedDate = ReviewReport::with('problems', 'comments')->where('patient_user_id', $id)
        ->latest('created_at')
        ->first();
        $ltsSession = ReviewReport::where('patient_user_id', $id)->where('is_session_visite', 1)->latest('created_at')->first();
        $patientProfile = PatientProfile::where('patient_user_id', $id)
        ->latest('created_at')
        ->first();
        $userid = $patientProfile->patient_user_id;
        $subscription = PatientSubscription::where('patient_user_id', $userid)->first();


        $session = PatientSubscription::where('patient_user_id', $userid)
        ->whereDate('subscript_date', '<=', $today)
        ->whereDate('expiry_date', '>=', $today)
        ->first();


        if($lastVisitedDate){
            return response()->json(['data'=>$lastVisitedDate, 'patient'=>$patientProfile, 'subscription'=>$subscription, 'session'=>$session, 'ltsSession'=>$ltsSession]);
        }
        else{
            return response()->json(['nodata'=>true, 'patient'=>$patientProfile, 'subscription'=>$subscription, 'session'=>$session, 'ltsSession'=>$ltsSession]);
        }

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReviewReport $reviewReport, $id)
    {
        $report = ReviewReport::with(['problems', 'patient', 'doctor', 'comments'])->findOrFail($id);
        $doctors = DoctorProfile::all();
        $patients = PatientProfile::all();
        $patient_medical_tests  = MedicalTest::all();
        $problems = Problem::all();
        $comments = Comment::all();
        $selectedProblems = $report->problems->pluck('id')->toArray();
        $count = ReviewReport::where('patient_user_id', $report->patient_user_id)->sum('session_visite_count');
        $selectedComment= $report->comments->pluck('id')->toArray();

        return view('medical_report.edit', compact('report', 'doctors', 'patients', 'patient_medical_tests', 'problems', 'selectedProblems', 'count', 'comments', 'selectedComment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReviewReport $reviewReport, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'patient_user_id' => 'required',
            'doctor_user_id' => 'required|exists:doctor_profiles,user_id',
            'no_of_visite' => 'required',
            'last_visited_date' => 'required|date',
            'bd_medicine' => 'nullable',
            'us_medicine' => 'nullable',
            'no_of_medicine' => 'required',
            'no_of_test' => 'nullable',
            'no_of_ozone_therapy' => 'nullable',
            'no_of_hijama_therapy' => 'nullable',
            'on_of_acupuncture' => 'nullable',
            'no_of_physiotherapy' => 'nullable',
            'no_of_coffee_anema' => 'nullable',
            'no_of_sauna' => 'nullable',
            'no_of_phototherapy' => 'nullable',
            'problem_id' => 'required',
            'physical_improvement' => 'required',
            'comment' => 'nullable|string',
            'comment_id' => 'required',
        ]);

        try {
            DB::enableQueryLog();

            // Log before finding the report
            Log::info("Attempting to update ReviewReport with ID: $id");

            // Find the review report by its ID
            $report = ReviewReport::findOrFail($id);

            // Log before updating report fields
            Log::info("Found ReviewReport. Updating fields...");

            $validatedData['no_of_ozone_therapy'] = $request->has('no_of_ozone_therapy') ? 1 : null;
            $validatedData['no_of_hijama_therapy'] = $request->has('no_of_hijama_therapy') ? 1 : null;
            $validatedData['on_of_acupuncture'] = $request->has('on_of_acupuncture') ? 1 : null;
            $validatedData['no_of_physiotherapy'] = $request->has('no_of_physiotherapy') ? 1 : null;
            $validatedData['no_of_coffee_anema'] = $request->has('no_of_coffee_anema') ? 1 : null;
            $validatedData['no_of_phototherapy'] = $request->has('no_of_phototherapy') ? 1 : null;
            $validatedData['no_of_sauna'] = $request->has('no_of_sauna') ? 1 : null;


            // Update the report fields
            $report->patient_user_id = $validatedData['patient_user_id'];
            $report->doctor_user_id = $validatedData['doctor_user_id'];

            $report->no_of_visite = $validatedData['no_of_visite'];
            $report->last_visited_date = $validatedData['last_visited_date'];
            $report->bd_medicine = $validatedData['bd_medicine'];
            $report->us_medicine = $validatedData['us_medicine'];
            $report->no_of_medicine = $validatedData['no_of_medicine'];
            $report->no_of_test = $validatedData['no_of_test'];
            $report->no_of_ozone_therapy = $validatedData['no_of_ozone_therapy'];
            $report->no_of_hijama_therapy = $validatedData['no_of_hijama_therapy'];
            $report->on_of_acupuncture =$validatedData['on_of_acupuncture'];
            $report->no_of_physiotherapy = $validatedData['no_of_physiotherapy'];
            $report->no_of_coffee_anema = $validatedData['no_of_coffee_anema'];
            $report->no_of_phototherapy = $validatedData['no_of_phototherapy'];
            $report->no_of_sauna = $validatedData['no_of_sauna'];
            $report->physical_improvement = $validatedData['physical_improvement'];
            $report->comment = $validatedData['comment'];
            $report->modified_by = Auth::user()->id;
            $doctor = $request->input('doctor_user_id');
            // Log before saving the report
            Log::info("Attempting to save ReviewReport changes...");

            // Save the report
            $report->save();

            // Log after saving the report
            Log::info("ReviewReport updated successfully.");

            // Sync problems if provided
                if (isset($validatedData['problem_id'])) {
                    Log::info("Syncing problems...");

                    // Sync the problems - this will add new ones and detach old ones
                    $report->problems()->sync($validatedData['problem_id']);

                    foreach ($validatedData['problem_id'] as $problemId) {
                        Log::info("Updating or creating for problem_id: {$problemId}", [
                            'doctor_user_id' => $report->doctor_user_id,
                            'last_visited_date' => $report->last_visited_date,
                            'patient_user_id' => $report->patient_user_id,
                        ]);
                        // Use updateOrCreate to update if exists or create if not
                        $problemToReport = ReportAndProblem::updateOrCreate(
                            [
                                'review_report_id' => $report->id,
                                'problem_id' => $problemId,
                            ],
                            [
                                'doctor_user_id' => $report->doctor_user_id,
                                'last_visited_date' => $report->last_visited_date,
                                'patient_user_id' => $report->patient_user_id,
                            ]
                        );
                    }
                    Log::info("Problems synced successfully.");
                }
            if (isset($validatedData['comment_id'])) {
                Log::info("Syncing Comments...");

                // Sync the comments - this will add new ones and detach old ones
                $report->comments()->sync($validatedData['comment_id']);

                foreach ($validatedData['comment_id'] as $commentId) {
                    // Use updateOrCreate to update if exists or create if not
                    $problemToReport = ReportAndComment::updateOrCreate(
                        [
                            'review_report_id' => $report->id,
                            'comment_id' => $commentId,
                        ],
                        [
                            'doctor_user_id' => $report->doctor_user_id,
                            'patient_user_id' => $report->patient_user_id,
                        ]
                    );
                }
            }
            $queries = DB::getQueryLog();
            foreach ($queries as $query) {
                Log::info('Executed Query: ', $query);
            }

            return response()->json(['success' => 'Patient Report updated successfully.'], 200);
        } catch (\Exception $e) {
            // Log error if an exception occurs
            Log::error("Error updating ReviewReport: " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReviewReport $reviewReport, $id)
    {
        try {
            $report = ReviewReport::find($id);
            $report->delete();
            return response()->json(['success'=>true]);
        } catch(\Exception $e){
            return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
        }

    }
}
