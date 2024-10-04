<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ReviewReport;
use App\Models\NutritionistVisit;
use App\Models\Problem;
use App\Models\ActivityLog;
use App\Models\Challenges;
use App\Models\ReportAndProblem;
use App\Models\VisitAndChallenge;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NutritionistVisitController extends Controller
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
                $data = NutritionistVisit::with('patient', 'report')->latest()->get(); // Fetch all doctor profiles

            } elseif ($user->role === 'user'|| 'nutritionist') {

                $startOfDay = Carbon::today();
                $endOfDay = Carbon::tomorrow();
                $data = NutritionistVisit::with('patient', 'report') // Fetch all doctor profiles
                ->whereBetween('created_at', [$startOfDay, $endOfDay])
                    ->orderBy('id', 'DESC') // Records older than 24 hours
                    ->get();
            } else {
                $data = collect(); // Return an empty collection if the role is not recognized
            }


            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn = '<a  data-id="'.$row->id.'"  class="editNuReport btn btn-primary btn-xs"><i class="fa-solid fa-pen-to-square"></i>Edit</a>&nbsp;';
                    $btn .= '<a  data-id="'.$row->id.'" class="deleteNuReport btn btn-danger btn-xs"><i class="fa-solid fa-trash"></i>Delete</a>';
                    return $btn;
                })
                ->addColumn('patient_name', function($data) {
                    return $data->patient->username ?? 'no name'; // Example: Accessing patient's first name
                })
                ->addColumn('doctor_name', function($data) {
                    return $data->report->doctor->name ?? 'No doctor'; // Accessing doctor's name
                })
                ->addColumn('visit_date', function($data) {
                    return $data->report->last_visited_date?? 'No Date'; // Accessing doctor's name
                })
                ->addColumn('no_of_visit', function($data) {
                    return $data->report->no_of_visite?? ' '; // Accessing doctor's name
                })
                ->addColumn('is_session_visite', function($data) {
                    return $data->report->is_session_visite ?? ' '; // Accessing doctor's name
                })
                ->addColumn('session_visite_count', function($data) {
                    return $data->report->session_visite_count ?? ' '; // Accessing doctor's name
                })
                ->addColumn('problems', function($data) {
                    if (isset($data->report) && $data->report->problems) {
                        // Ensure problems is a collection or array before plucking names
                        return $data->report->problems->pluck('name')->implode(', ');
                    }
                    // Return a default value if problems is null or not set
                    return ' ';
                })
                ->addColumn('nutritionist', function($data) {
                    if($data->nutritionist){
                        return $data->nutritionist->name;
                    }
                    return ' ';
                })
                ->addColumn('editor', function($data) {
                    if($data->editor){
                        return $data->editor->name;
                    }
                    return '';
                })
                ->rawColumns(['action', 'patient_name','doctor_name', 'visit_date', 'no_of_visit', 'is_session_visite','session_visite_count', 'problems',  'nutritionist'])
                ->make(true);
        }

        return view('nutritionist_visit.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $report = NutritionistVisit::with(['problems', 'challenges'])->find($id);
        $problems = Problem::all();
        $selectedProblems =  $report->problems->pluck('id')->toArray();
        $selectChallenge =  $report->challenges->pluck('id')->toArray();
        $challenges = Challenges::all();
        return view('nutritionist_visit.edit', compact('report', 'problems', 'selectedProblems', 'challenges', 'selectChallenge'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request
        $validator = $request->validate([
            'problem_id' => 'required|array',
            'type_of_consultant' => 'required|integer',
            'challanced_faced' => 'required|array',
            'challanced_faced.*' => 'integer',
            'diet_plan_status' => 'required|integer',
            'diet_plan_satisfaction' => 'required|integer',
            'suggetion_for_improvement' => 'nullable|string',
            'visit_duration' => 'required|numeric|min:1',
            'treatment_satisfaction' => 'required',

        ]);
        // Find the report by ID
        $report = NutritionistVisit::find($id);

        if (!$report) {
            Log::error('Report not found', ['id' => $id]);
            return redirect()->back()->with('error', 'Report not found.');
        }

        // Prepare the update data
        $updateData = [
            'type_of_consultant' => $request->input('type_of_consultant'),
            'diet_plan_status' => $request->input('diet_plan_status'),
            'diet_plan_satisfaction' => $request->input('diet_plan_satisfaction'),
            'treatment_satisfaction' => $request->input('treatment_satisfaction'),
            'suggetion_for_improvement' => $request->input('suggetion_for_improvement'),
            'visit_duration' => $request->input('visit_duration'),
            'updated_by' => Auth::id(), // Always set updated_by to the current user
        ];

        // Conditionally add the 'nutritionist_user_id' attribute
        if (Auth::user()->role == 'nutritionist') {
            $updateData['nutritionist_user_id'] = Auth::id();
        }
        // Log the update attempt
        $newChallenges = $validator['challanced_faced'];

        // Get existing challenges for this visit
        $existingChallenges = VisitAndChallenge::where('nutritionist_visit_id', $id)
            ->where('nutritionist_user_id', $report->nutritionist_user_id)
            ->where('patient_user_id', $report->patient_user_id)
            ->pluck('challenge_id')
            ->toArray();

        // Determine challenges to add
        $challengesToAdd = array_diff($newChallenges, $existingChallenges);

        // Determine challenges to delete
        $challengesToDelete = array_diff($existingChallenges, $newChallenges);

        // Add new challenges
        foreach ($challengesToAdd as $challengeId) {
            VisitAndChallenge::create([
                'nutritionist_visit_id' => $id,
                'challenge_id' => $challengeId,
                'nutritionist_user_id' => $report->nutritionist_user_id,
                'patient_user_id' => $report->patient_user_id,
            ]);
        }

        // Delete removed challenges
        VisitAndChallenge::where('nutritionist_visit_id', $id)
            ->whereIn('challenge_id', $challengesToDelete)
            ->delete();



        Log::info('Attempting to update report', [
            'id' => $id,
            'updateData' => $updateData,
            'user_id' => Auth::id(),
            'treatment_satisfaction' => $request->input('treatment_satisfaction'), // Log treatment_satisfaction specifically
            'nutritionist'=> $report->nutritionist_user_id,
        ]);
        Log::info('Checking treatment_satisfaction', [

            'treatment_satisfaction' => $request->input('treatment_satisfaction'), // Log treatment_satisfaction specifically

        ]);

        // Perform the update
        try {
            $report->update($updateData);
            if (isset($validator['problem_id'])) {
                Log::info("Syncing problems...");
                $report->problems()->sync($validator['problem_id']);

                foreach ($validator['problem_id'] as $problemId) {
                    // Use updateOrCreate to update if exists or create if not
                    $problemToReport = ReportAndProblem::firstOrNew([
                        'review_report_id' => $report->review_report_id ,
                        'problem_id' => $problemId,
                        'nutritionist_visit_id' => $report->nutritionist_visit_id ,
                    ]);
                    $problemToReport->save();
                }


                Log::info("Problems synced successfully.");
            }

            // Log successful update
            Log::info('Report updated successfully', [
                'id' => $id,
                'updated_by' => Auth::id(),
            ]);

            // Log the activity
            ActivityLog::create([
                'subject' => 'Report Update by User ID: ' . Auth::id(),
                'modified_by' => Auth::id(),
            ]);

            return response()->json(['success' => true, 'message' => 'Report updated successfully'], 200);
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Update failed', [
                'id' => $id,
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['success' => false, 'message' => 'Failed to update report'], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the Nutritionist item by its ID
            $item = NutritionistVisit::find($id);

            if ($item) {
                // Log the deletion attempt
                Log::info('Attempting to delete Nutritionist visit ID: ' . $id);

                // Delete the item
                $item->delete();

                // Log successful deletion
                Log::info('Successfully deleted Nutritionist visit ID: ' . $id);

                // Return JSON response for successful deletion
                return response()->json(['success' => true], 200);
            }

            // Log the item not found situation
            Log::warning('Nutritionist visit ID not found: ' . $id);

            // Return JSON response for item not found
            return response()->json(['success' => false, 'message' => 'Item not found'], 404);

        } catch (\Exception $e) {
            // Log any exceptions that occur
            Log::error('Error deleting Nutritionist visit ID: ' . $id . '. Error: ' . $e->getMessage());

            // Return JSON response for internal server error
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }

    }
}
