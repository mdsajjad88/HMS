<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorProfile;
use App\Models\User;
use App\Models\PatientProfile;
use App\Models\ReportAndProblem;
use App\Models\ReviewReport;
use App\Models\Problem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash; // Import Hash facade for password hashing
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DoctorController extends Controller
{
    public function index(){
        if(Auth::user()->role != 'admin'){
            return route('dashboard');
        }
        return view('doctor.index');
    }
    public function  create(){
        return view('doctor.add');
    }
    public function store(Request $request){

                $validatedata = $request->validate([
                    'first_name' => 'required|string',

                    'email' => 'nullable|email|unique:doctor_profiles,email',
                    'mobile' => 'nullable|digits:11|numeric',
                    'gender' => 'required|in:Male,Female,Other',
                    'bmdc_number' => 'nullable|string',
                    'blood_group' => 'nullable|string',
                    'date_of_birth' => 'nullable|date',
                    'nid' => 'nullable|string',
                    'specialist' => 'nullable|string',
                    'fee' => 'nullable|numeric',
                    'designation' => 'nullable|string',
                    'consultant_type' => 'nullable|string',
                    'address' => 'nullable|string',
                    'description' => 'nullable|string', // 2MB max
                ],[
                    'email.unique'=>'Sorry!  This email already have taken !!!'
                ]);

                 // Get email from the request or set a temporary email
                $email = $request->input('email');
                if (!$email) {
                    $email = $request->input('first_name').'_'.Str::random(4) . '@example.com'; // Generate a unique temporary email
                }

                // Create the user
                $doctor = new User();
                $doctor->name = $request->input('first_name');
                $doctor->email = $email; // Use the provided or temporary email
                $doctor->email_verified_at = now();
                $doctor->password = Hash::make($request->input('password')); // Hash the password
                $doctor->save();

                // Log the newly created doctor user details
                Log::info('Doctor created:', ['id' => $doctor->id, 'email' => $doctor->email]);

                $doctorID = $doctor->id;
                $mail = $doctor->email;

                // Create a new DoctorProfile and associate it with the User
                $doctorProfile = new DoctorProfile();
                $doctorProfile->user_id = $doctorID; // Assign user_id
                $doctorProfile->email = $mail; // Assign email
                $doctorProfile->created_by = Auth::user()->id; // Assign created_by
                $doctorProfile->last_name = $request->input('last_name', ''); // Assuming you want to store a last name
                // Explicitly fill remaining fields except 'email'
                $doctorProfile->fill($request->except(['email'])); // Avoid overwriting the email field
                $doctorProfile->save();

                // Log the doctor profile creation
                Log::info('DoctorProfile created:', $doctorProfile->toArray());

                return response()->json(['success' => true]);

        }
        public function show(Request $request){
            if ($request->ajax()) {
                $user = Auth::user(); // Get the currently authenticated user
                // Check user role and set up query
                if ($user->role == 'admin') {
                    $data = DoctorProfile::latest()->orderBy('id', 'DESC')->get();
                }
                return DataTables::of($data)
                    ->addColumn('action', function($row){
                        $btn = '<a  data-id="'.$row->id.'" class="editDoctor btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i>Edit</a>';
                        $btn .= ' <a  data-id="'.$row->id.'" class="deleteDoctor btn btn-danger btn-sm"><i class="fa-solid fa-trash-arrow-up"></i>Delete</a>';
                        $btn .= ' <a  data-id="'.$row->id.'" class="viewDoctor btn btn-info btn-sm"><i class="fa-regular fa-eye"></i>View</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }


        }
    public function edit($id){
        $doctor = DoctorProfile::find($id);
        return view('doctor.edit', compact('doctor'));
    }
    public function update(Request $request){
        // dd($request->all());
        $id = $request->input('doctorId');
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'email' => 'nullable|email|unique:doctor_profiles,email,'.$id,
            'mobile' => 'nullable|digits:11|numeric',
            'gender' => 'required|in:Male,Female,Other',
            'bmdc_number' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'nid' => 'nullable|string',
            'specialist' => 'nullable|string',
            'fee' => 'nullable|numeric',
            'designation' => 'nullable|string',
            'consultant_type' => 'nullable|string',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        // Find the doctor profile to update
        $doctorProfile = DoctorProfile::findOrFail($id);
        $doctorProfile->modified_by = Auth::user()->id;
        $doctorProfile->fill($request->all());

        try {
            $doctorProfile->save();
            return response()->json(['success' => 'Doctor profile updated successfully.', 'doctor' => $doctorProfile], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
        }
    }
    public function destroy($id)
    {
         // Find the patient by ID
         $patient = DoctorProfile::findOrFail($id);

         // Delete the patient
         $patient->delete();

         // Optionally, you can redirect back with a success message
         return response()->json(['success', 'Doctor deleted successfully!']);
    }
    public function view($id, $days){
        $allProblems = Problem::all();
        if($days == 1){

            $currentDate = Carbon::now();
            // $startDate = $currentDate->startOfMonth()->format("Y-m-d");
            // $endDate = $currentDate->endOfMonth()->format("Y-m-d");
            $startDate = $currentDate->copy()->subDays(30)->startOfDay()->format('Y-m-d');
            $endDate = $currentDate->copy()->endOfDay()->format('Y-m-d');


            $doctor = DoctorProfile::find($id);
            $doctorID = $doctor->user_id;
            $no_of_test = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_test');
            $no_of_medicine = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_medicine');
            $no_of_ozone_therapy = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_ozone_therapy');
            $no_of_hijama_therapy = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_hijama_therapy');
            $on_of_acupuncture = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('on_of_acupuncture');
            $no_of_sauna = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_sauna');
            $no_of_physiotherapy = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_physiotherapy');
            $no_of_coffee_anema = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_coffee_anema');
            $no_of_phototherapy = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_phototherapy');
            $bd_medicine = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('bd_medicine');
            $us_medicine = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('us_medicine');
            $total_patient = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->distinct('patient_user_id')->count('patient_user_id');
            $total_visite = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->count('patient_user_id');
            $problemIds = ReviewReport::where('doctor_user_id', $doctorID)
            ->whereBetween('last_visited_date', [$startDate, $endDate])
            ->pluck('id');
            $totalProblems = ReportAndProblem::whereIn('review_report_id', $problemIds)->count('review_report_id');

            $problems = ReportAndProblem::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->get();
            // Group by problem_id and count occurrences
            $problemCounts = $problems->groupBy('problem_id')->map(function ($group) {
                return $group->count();
            });
        }
        if($days == "2"){
            $now = Carbon::now();
            $startDate = $now->copy()->subDays(60)->startOfDay()->format("Y-m-d");
            $endDate = $now->copy()->endOfDay()->format('Y-m-d');
            $doctor = DoctorProfile::find($id);
            $doctorID = $doctor->user_id;

            $no_of_test = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_test');
            $no_of_medicine = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_medicine');
            $no_of_ozone_therapy = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_ozone_therapy');
            $no_of_hijama_therapy = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_hijama_therapy');
            $on_of_acupuncture = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('on_of_acupuncture');
            $no_of_sauna = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_sauna');
            $no_of_physiotherapy = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_physiotherapy');
            $no_of_coffee_anema = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_coffee_anema');
            $no_of_phototherapy = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_phototherapy');
            $bd_medicine = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('bd_medicine');
            $us_medicine = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('us_medicine');
            $total_patient = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->distinct('patient_user_id')->count('patient_user_id');
            $total_visite = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->count('patient_user_id');
            $problemIds = ReviewReport::where('doctor_user_id', $doctorID)
            ->whereBetween('last_visited_date', [$startDate, $endDate])
            ->pluck('id');
            $totalProblems = ReportAndProblem::whereIn('review_report_id', $problemIds)->count('problem_id');

            $problems = ReportAndProblem::where('doctor_user_id', $doctorID)
                ->whereBetween('last_visited_date', [$startDate, $endDate])
                ->get();
            // Group by problem_id and count occurrences
            $problemCounts = $problems->groupBy('problem_id')->map(function ($group) {
                return $group->count();
            });



        }
        if($days == "9"){
            $now = Carbon::now();
            $startDate = $now->copy()->subDays(90)->startOfDay()->format('Y-m-d');
            $endDate = $now->copy()->endOfDay()->format('Y-m-d');

            // $startDate = Carbon::now()->subDays($days);
            $doctor = DoctorProfile::find($id);
            $doctorID = $doctor->user_id;

            $no_of_test = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_test');
            $no_of_medicine = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_medicine');
            $no_of_ozone_therapy = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_ozone_therapy');
            $no_of_hijama_therapy = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_hijama_therapy');
            $on_of_acupuncture = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('on_of_acupuncture');
            $no_of_sauna = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_sauna');
            $no_of_physiotherapy = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_physiotherapy');
            $no_of_coffee_anema = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_coffee_anema');
            $no_of_phototherapy = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_phototherapy');
            $bd_medicine = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('bd_medicine');
            $us_medicine = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('us_medicine');
            $total_patient = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->distinct('patient_user_id')->count('patient_user_id');
            $total_visite = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->count('patient_user_id');
            $problemIds = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->pluck('id');
            $totalProblems = ReportAndProblem::whereIn('review_report_id', $problemIds)->count('problem_id');

            $problems = ReportAndProblem::where('doctor_user_id', $doctorID)
                ->whereBetween('last_visited_date', [$startDate, $endDate])
                ->get();
            // Group by problem_id and count occurrences
            $problemCounts = $problems->groupBy('problem_id')->map(function ($group) {
                return $group->count();
            });

        }
        if($days == "12"){
            $startDate = Carbon::now()->subYear()->format("Y-m-d");
            $endDate = Carbon::now()->format("Y-m-d");

            // $startDate = Carbon::now()->subDays($days);
            $doctor = DoctorProfile::find($id);
            $doctorID = $doctor->user_id;

            $no_of_test = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_test');
            $no_of_medicine = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_medicine');
            $no_of_ozone_therapy = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_ozone_therapy');
            $no_of_hijama_therapy = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_hijama_therapy');
            $on_of_acupuncture = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('on_of_acupuncture');
            $no_of_sauna = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_sauna');
            $no_of_physiotherapy = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_physiotherapy');
            $no_of_coffee_anema = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_coffee_anema');
            $no_of_phototherapy = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('no_of_phototherapy');
            $bd_medicine = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('bd_medicine');
            $us_medicine = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->sum('us_medicine');
            $total_patient = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->distinct('patient_user_id')->count('patient_user_id');
            $total_visite = ReviewReport::where('doctor_user_id', $doctorID)->whereBetween('last_visited_date', [$startDate, $endDate])->count('patient_user_id');
            $problemIds = ReviewReport::where('doctor_user_id', $doctorID)
            ->whereBetween('last_visited_date', [$startDate, $endDate])
            ->pluck('id');
            $totalProblems = ReportAndProblem::whereIn('review_report_id', $problemIds)->count('problem_id');

            $problems = ReportAndProblem::where('doctor_user_id', $doctorID)
                ->whereBetween('last_visited_date', [$startDate, $endDate])
                ->get();
            // Group by problem_id and count occurrences
            $problemCounts = $problems->groupBy('problem_id')->map(function ($group) {
                return $group->count();
            });


        }
        if($days == "all"){
            $startDate = '2024-07-26';
            $endDate = Carbon::now()->format("Y-m-d");
            // $startDate = Carbon::now()->subDays($days);
            $doctor = DoctorProfile::find($id);
            $doctorID = $doctor->user_id;

            $no_of_test = ReviewReport::where('doctor_user_id', $doctorID)->sum('no_of_test');
            $no_of_medicine = ReviewReport::where('doctor_user_id', $doctorID)->sum('no_of_medicine');
            $no_of_ozone_therapy = ReviewReport::where('doctor_user_id', $doctorID)->sum('no_of_ozone_therapy');
            $no_of_hijama_therapy = ReviewReport::where('doctor_user_id', $doctorID)->sum('no_of_hijama_therapy');
            $on_of_acupuncture = ReviewReport::where('doctor_user_id', $doctorID)->sum('on_of_acupuncture');
            $no_of_sauna = ReviewReport::where('doctor_user_id', $doctorID)->sum('no_of_sauna');
            $no_of_physiotherapy = ReviewReport::where('doctor_user_id', $doctorID)->sum('no_of_physiotherapy');
            $no_of_coffee_anema = ReviewReport::where('doctor_user_id', $doctorID)->sum('no_of_coffee_anema');
            $no_of_phototherapy = ReviewReport::where('doctor_user_id', $doctorID)->sum('no_of_phototherapy');
            $bd_medicine = ReviewReport::where('doctor_user_id', $doctorID)->sum('bd_medicine');
            $us_medicine = ReviewReport::where('doctor_user_id', $doctorID)->sum('us_medicine');
            $total_patient = ReviewReport::where('doctor_user_id', $doctorID)->distinct('patient_user_id')->count('patient_user_id');
            $total_visite = ReviewReport::where('doctor_user_id', $doctorID)->count('patient_user_id');
            $problemIds = ReviewReport::where('doctor_user_id', $doctorID)->pluck('id');
            $totalProblems = ReportAndProblem::whereIn('review_report_id', $problemIds)->count('problem_id');

            $problems = ReportAndProblem::where('doctor_user_id', $doctorID)->get();
            // Group by problem_id and count occurrences
            $problemCounts = $problems->groupBy('problem_id')->map(function ($group) {
                return $group->count();
            });
        }
        return view('doctor.view', compact('no_of_test', 'no_of_medicine', 'no_of_ozone_therapy', 'no_of_hijama_therapy', 'on_of_acupuncture', 'no_of_sauna', 'no_of_physiotherapy', 'no_of_coffee_anema','no_of_phototherapy',  'id', 'days', 'doctor', 'startDate', 'endDate', 'total_patient', 'bd_medicine', 'us_medicine', 'totalProblems', 'problems', 'allProblems', 'problemCounts', 'total_visite'));
    }

}

