<?php

namespace App\Http\Controllers;

use App\Models\DoctorProfile;
use App\Models\GeoDistricts;
use App\Models\GeoUpazillas;
use Illuminate\Http\Request;
use App\Models\PatientProfile;
use App\Models\PatientUser;
use App\Models\Problem;
use App\Models\PatientSubscription;
use finfo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use App\Models\ReviewReport;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
       return view('patient.index');
    }
    public function getPatient(Request $request)
    {

            if ($request->ajax()) {
                $user = Auth::user(); // Get the currently authenticated user

                // Check user role and set up query
                if ($user->role == 'admin') {
                    $data = PatientProfile::latest()->get(); // Admin sees all records
                } elseif ($user->role == 'user') {

                    $startOfDay = Carbon::today();
                    $endOfDay = Carbon::tomorrow();
                        $data = PatientProfile::latest()
                        ->whereBetween('created_at', [$startOfDay, $endOfDay])
                            ->get();
                    } else {
                        $data = collect(); // Return an empty collection if the role is not recognized
                    }
            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn = '<a  data-id="'.$row->id.'"  class="editPatient btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i>Edit</a>';
                    $btn .= '<a  data-id="'.$row->id.'" class="deletePatient btn btn-danger ml-1 btn-sm"><i class="fa-solid fa-trash-arrow-up"></i>Delete</a>';
                    $btn .= ' <a  data-id="'.$row->id.'" class="viewPatientProfile btn btn-info btn-sm"><i class="fa-regular fa-eye"></i>Profile</a>';

                    return $btn;
                })
                ->addColumn('district_name', function($data) {
                    return $data->district->district_name_eng; // Example: Accessing patient's first name
                })
                ->addColumn('user_name', function($data) {
                    return $data->user->name; // Example: Accessing patient's first name
                })
                ->rawColumns(['action'])
                ->make(true);
        }


    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $districts = GeoDistricts::orderBy('district_name_eng', 'ASC')->get();

        return view('patient.create', compact('districts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Log the request data
            Log::info('Store method called with request data:', $request->all());

            // Validate the incoming request data
            $validatedData = $request->validate([
                'first_name' => 'required|string',
                'email' => 'nullable',
                'mobile' => 'required|digits:11|numeric',
                'gender' => 'required|in:Male,Female,Other',
                'age' => 'required|integer',
                'nid' => 'nullable|string',
                'blood_group' => 'nullable|string',
                'emergency_phone' => 'nullable|string',
                'emergency_relation' => 'nullable|string',
                'address' => 'nullable|string',
                'geo_district_id' => 'required',
                'geo_upazila_id' => 'nullable',
                'profession' => 'nullable|string',
                'referral' => 'nullable|string',
                'patient_type_id' => 'nullable',
                'subscript_date' => 'nullable',
                'session_visite_count' => 'nullable',

            ]);

            // Log validated data
            Log::info('Validated data:', $validatedData);

           // Log validated data
           Log::info('Validated data:', $validatedData);
           $existsContact = PatientProfile::where('mobile', $validatedData['mobile'])->exists();
           $existsName = PatientProfile::where('first_name', $validatedData['first_name'])->exists();

           if ($existsContact && $existsName) {
               // Log the duplicate phone number error
               Log::error('Duplicate name and phone number detected.', ['mobile' => $validatedData['mobile']]);
               return response()->json(['error' => 'The name and phone number is already in use.'], 422);
           }

            $visitCount = $request->input('session_visite_count');

            // Create a new PatientUser
            $patientUser = new PatientUser();
            $patientUser->username = $request->input('first_name');
            $patientUser->password = $request->input('mobile');
            $patientUser->user_body = $request->input('address');
            $patientUser->created_by = Auth::user()->id;
            $patientUser->save();

            // Log the created PatientUser ID
            Log::info('Created PatientUser with ID:', ['id' => $patientUser->id]);

            $patientUserId = $patientUser->id;

            // Create a new PatientProfile and associate it with the PatientUser
            $patientProfile = new PatientProfile();
            $patientProfile->patient_user_id = $patientUserId;
            $patientProfile->created_by = Auth::user()->id;
            $patientProfile->created = now();
            $patientProfile->modified = now();
            $patientProfile->geo_district_id = $validatedData['geo_district_id'];
            $patientProfile->fill($validatedData);

            // Save the PatientProfile
            if ($patientProfile->save()) {
                Log::info('PatientProfile saved successfully.', ['id' => $patientProfile->id]);

                // Handle subscription based on patient_type_id
                if ($validatedData['patient_type_id'] == 3 || $validatedData['patient_type_id'] == 6) {
                    $startDate = Carbon::parse($validatedData['subscript_date']);
                    $endDate = $startDate->copy()->addMonths($validatedData['patient_type_id'] == 3 ? 3 : 6)->endOfDay()->format('Y-m-d');

                    $subscription = new PatientSubscription();
                    $subscription->patient_user_id = $patientUserId;
                    $subscription->subscript_date = $startDate;
                    $subscription->expiry_date = $endDate;
                    $subscription->created_by = Auth::user()->id;
                    $subscription->save();

                    Log::info('PatientSubscription created.', [
                        'patient_user_id' => $patientUserId,
                        'subscript_date' => $startDate,
                        'expiry_date' => $endDate
                    ]);
                    if($visitCount > 0){
                        $reportAdd = new ReviewReport();
                        $reportAdd->patient_user_id = $validatedData['patient_user_id'] ?? $patientUserId; // Use a default value
                        $reportAdd->doctor_user_id = 2; // Use a default value
                        $reportAdd->mobile = $validatedData['mobile'];
                        $reportAdd->created_by = Auth::user()->id;
                        $reportAdd->no_of_visite = $visitCount;
                        $reportAdd->last_visited_date = $validatedData['subscript_date'];
                        $patientTypeId = (int)($validatedData['patient_type_id'] ?? 0);

                        $reportAdd->is_session_visite = $patientTypeId == 3?1:0;
                        $reportAdd->session_visite_count = $visitCount;
                        $reportAdd->save();

                        Log::info('ReviewReport created.', [
                            'patient_user_id' => $reportAdd->patient_user_id,
                            'no_of_visite' => $reportAdd->no_of_visite
                        ]);
                        Log::info('is_session_visite value set to:', ['value' => $reportAdd->is_session_visite]);
                    }


                }
                else if ($validatedData['patient_type_id'] == 33) {
                    $startDate = Carbon::parse($validatedData['subscript_date']);
                    $endDate = $startDate->copy()->addMonths($validatedData['patient_type_id'] == 33 ? 3 : 6)->endOfDay()->format('Y-m-d');

                    $subscription = new PatientSubscription();
                    $subscription->patient_user_id = $patientUserId;
                    $subscription->subscript_date = $startDate;
                    $subscription->expiry_date = $endDate;
                    $subscription->created_by = Auth::user()->id;
                    $subscription->save();

                    Log::info('PatientSubscription created.', [
                        'patient_user_id' => $patientUserId,
                        'subscript_date' => $startDate,
                        'expiry_date' => $endDate
                    ]);
                    if($visitCount > 0){
                        $reportAdd = new ReviewReport();
                        $reportAdd->patient_user_id = $validatedData['patient_user_id'] ?? $patientUserId; // Use a default value
                        $reportAdd->doctor_user_id = 2; // Use a default value
                        $reportAdd->mobile = $validatedData['mobile'];
                        $reportAdd->created_by = Auth::user()->id;
                        $reportAdd->no_of_visite = $visitCount;
                        $reportAdd->last_visited_date = $validatedData['subscript_date'];
                        $reportAdd->is_session_visite = 1;
                        $reportAdd->session_visite_count = $visitCount;
                        $reportAdd->save();

                        Log::info('ReviewReport created.', [
                            'patient_user_id' => $reportAdd->patient_user_id,
                            'no_of_visite' => $reportAdd->no_of_visite
                        ]);
                    };

                }

                return response()->json(['success' => $patientProfile]);
            } else {
                Log::error('Failed to save PatientProfile.');
                return response()->json(['error' => 'Something went wrong, please try again.']);
            }
        } catch (\Exception $e) {
            // Log the exception message
            Log::error('Exception occurred while storing data:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'An unexpected error occurred.']);
        }
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
        $districts= GeoDistricts::all();
        $states= GeoUpazillas::all();
        $patient = PatientProfile::find($id);
        $id = $patient->patient_user_id;
        $report = ReviewReport::where('patient_user_id', $id)->latest('created_at')->first();
        $subscription = PatientSubscription::where('patient_user_id', $id)->first();

        return view('patient.edit', compact('id', 'states', 'districts', 'patient', 'report', 'subscription'));
   }


    // public function update(Request $request)
    // {

    //     try {
    //         // Log the incoming request data
    //         Log::info('Update request data:', $request->all());

    //         // Validate the incoming request data
    //         $validatedData = Validator::make($request->all(), [
    //             'first_name' => 'required|string',
    //             'email' => 'nullable',
    //             'mobile' => 'required|digits:11|numeric',
    //             'gender' => 'required|in:Male,Female,Other',
    //             'age' => 'required|integer',
    //             'nid' => 'nullable|string',
    //             'marital_status' => 'nullable|in:Married,Unmarried,Other',
    //             'blood_group' => 'nullable|string',
    //             'emergency_phone' => 'nullable|string',
    //             'emergency_relation' => 'nullable|string',
    //             'address' => 'nullable|string',
    //             'geo_district_id' => 'required',
    //             'geo_upazila_id' => 'nullable',
    //             'profession' => 'nullable|string',
    //             'referral' => 'nullable|string',
    //             'patient_type_id' => 'nullable',
    //             'subscript_date' => 'nullable',
    //             'session_visite_count' => 'nullable',
    //         ]);

    //         // Log validation errors if any
    //         if ($validatedData->fails()) {
    //             Log::error('Validation failed:', $validatedData->errors()->toArray());
    //             return response()->json(['error' => $validatedData->errors()->first()], 400);
    //         }

    //         // Find the patient profile to update
    //         $id = $request->input('id');
    //         $patientProfile = PatientProfile::findOrFail($id);
    //         $patientProfile->modified_by = Auth::user()->id;
    //         $patientProfile->fill($request->all());

    //         $user = PatientUser::where('id', $patientProfile->patient_user_id)->first();
    //         $patientProfile->save();


    //     $patientTypeId = $request->input('patient_type_id');

    //     if ($patientTypeId == "3" || $patientTypeId == "6") {

    //         $startDateString = $request->input('subscript_date');

    //         // Convert the string to a Carbon instance
    //         $startDate = Carbon::parse($startDateString);

    //         // Calculate the end date based on patient_type_id
    //         $monthsToAdd = ($request->input('patient_type_id') == 3) ? 3 : 6;
    //         $endDate = $startDate->copy()->addMonths($monthsToAdd)->endOfDay()->format('Y-m-d');
    //         $subs = PatientSubscription::where('patient_user_id', $user->id)->first();


    //         if ($subs) {
    //             $subscription = PatientSubscription::find($subs->id);
    //             $subscription->subscript_date = $startDate->format('Y-m-d');
    //             $subscription->expiry_date = $endDate;
    //             $subscription->modified_by = Auth::user()->id;
    //             $subscription->save();

    //             Log::info('PatientSubscription updated or created.', [
    //                 'patient_user_id' => $user,
    //                 'subscript_date' => $startDate->format('Y-m-d'),
    //                 'expiry_date' => $endDate
    //             ]);
    //         }

    //     // Update or create a review report
    //         $reportID = ReviewReport::where('patient_user_id', $user->id)->first();

    //         if ($reportID) {
    //             $report = ReviewReport::find($reportID->id);
    //             $report->doctor_user_id = 2; // Use a default value
    //             $report->mobile = $request->input('mobile');
    //             $report->created_by = Auth::user()->id;
    //             $report->no_of_visite = $request->input('session_visite_count');
    //             $report->last_visited_date = $startDate->format('Y-m-d'); // Ensure this is in 'Y-m-d' format
    //             $report->is_session_visite = 1;
    //             $report->session_visite_count = $request->input('session_visite_count');
    //             $report->save();

    //             Log::info('ReviewReport updated or created.', [
    //                 'patient_user_id' => $report->patient_user_id,
    //                 'no_of_visite' => $report->no_of_visite
    //             ]);
    //         }
    //     }

    //         // Handle subscription logic


    //         // Return a success response
    //         return response()->json(['success' => 'Patient profile updated successfully.', 'doctor' => $patientProfile], 200);

    //     } catch (\Exception $e) {
    //         // Log the exception message and stack trace
    //         Log::error('Exception occurred while updating patient profile:', [
    //             'message' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);
    //         return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
    //     }
    // }

    public function update(Request $request)
    {
        try {
            // Log the request data
            Log::info('Store method called with request data:', $request->all());

            // Validate the incoming request data
            $validatedData = $request->validate([
                'first_name' => 'required|string',
                'email' => 'nullable',
                'mobile' => 'required|digits:11|numeric',
                'gender' => 'required|in:Male,Female,Other',
                'age' => 'required|integer',
                'nid' => 'nullable|string',
                'blood_group' => 'nullable|string',
                'emergency_phone' => 'nullable|string',
                'emergency_relation' => 'nullable|string',
                'address' => 'nullable|string',
                'geo_district_id' => 'required',
                'geo_upazila_id' => 'nullable',
                'profession' => 'nullable|string',
                'referral' => 'nullable|string',
                'patient_type_id' => 'nullable',
                'subscript_date' => 'nullable',
                'session_visite_count' => 'nullable',

            ]);

            // Log validated data
            Log::info('Validated data:', $validatedData);

           // Log validated data
           Log::info('Validated data:', $validatedData);
           $existsContact = PatientProfile::where('mobile', $validatedData['mobile'])->exists();
           $existsName = PatientProfile::where('first_name', $validatedData['first_name'])->exists();

           if ($existsContact && $existsName) {
               // Log the duplicate phone number error
               Log::error('Duplicate name and phone number detected.', ['mobile' => $validatedData['mobile']]);
               return response()->json(['error' => 'The name and phone number is already in use.'], 422);
           }

            $visitCount = $request->input('session_visite_count');

            // Create a new PatientUser
            $patientUser = new PatientUser();
            $patientUser->username = $request->input('first_name');
            $patientUser->password = $request->input('mobile');
            $patientUser->user_body = $request->input('address');
            $patientUser->created_by = Auth::user()->id;
            $patientUser->save();

            // Log the created PatientUser ID
            Log::info('Created PatientUser with ID:', ['id' => $patientUser->id]);

            $patientUserId = $patientUser->id;

            // Create a new PatientProfile and associate it with the PatientUser
            $patientProfile = new PatientProfile();
            $patientProfile->patient_user_id = $patientUserId;
            $patientProfile->created_by = Auth::user()->id;
            $patientProfile->created = now();
            $patientProfile->modified = now();
            $patientProfile->geo_district_id = $validatedData['geo_district_id'];
            $patientProfile->fill($validatedData);

            // Save the PatientProfile
            if ($patientProfile->save()) {
                Log::info('PatientProfile saved successfully.', ['id' => $patientProfile->id]);

                // Handle subscription based on patient_type_id
                if ($validatedData['patient_type_id'] == 3 || $validatedData['patient_type_id'] == 6) {
                    $startDate = Carbon::parse($validatedData['subscript_date']);
                    $endDate = $startDate->copy()->addMonths($validatedData['patient_type_id'] == 3 ? 3 : 6)->endOfDay()->format('Y-m-d');

                    $subscription = new PatientSubscription();
                    $subscription->patient_user_id = $patientUserId;
                    $subscription->subscript_date = $startDate;
                    $subscription->expiry_date = $endDate;
                    $subscription->created_by = Auth::user()->id;
                    $subscription->save();

                    Log::info('PatientSubscription created.', [
                        'patient_user_id' => $patientUserId,
                        'subscript_date' => $startDate,
                        'expiry_date' => $endDate
                    ]);
                    if($visitCount > 0){
                        $reportAdd = new ReviewReport();
                        $reportAdd->patient_user_id = $validatedData['patient_user_id'] ?? $patientUserId; // Use a default value
                        $reportAdd->doctor_user_id = 2; // Use a default value
                        $reportAdd->mobile = $validatedData['mobile'];
                        $reportAdd->created_by = Auth::user()->id;
                        $reportAdd->no_of_visite = $visitCount;
                        $reportAdd->last_visited_date = $validatedData['subscript_date'];
                        $patientTypeId = (int)($validatedData['patient_type_id'] ?? 0);

                        $reportAdd->is_session_visite = $patientTypeId == 3?1:0;
                        $reportAdd->session_visite_count = $visitCount;
                        $reportAdd->save();

                        Log::info('ReviewReport created.', [
                            'patient_user_id' => $reportAdd->patient_user_id,
                            'no_of_visite' => $reportAdd->no_of_visite
                        ]);
                        Log::info('is_session_visite value set to:', ['value' => $reportAdd->is_session_visite]);
                    }


                }
                else if ($validatedData['patient_type_id'] == 33) {
                    $startDate = Carbon::parse($validatedData['subscript_date']);
                    $endDate = $startDate->copy()->addMonths($validatedData['patient_type_id'] == 33 ? 3 : 6)->endOfDay()->format('Y-m-d');

                    $subscription = new PatientSubscription();
                    $subscription->patient_user_id = $patientUserId;
                    $subscription->subscript_date = $startDate;
                    $subscription->expiry_date = $endDate;
                    $subscription->created_by = Auth::user()->id;
                    $subscription->save();

                    Log::info('PatientSubscription created.', [
                        'patient_user_id' => $patientUserId,
                        'subscript_date' => $startDate,
                        'expiry_date' => $endDate
                    ]);
                    if($visitCount > 0){
                        $reportAdd = new ReviewReport();
                        $reportAdd->patient_user_id = $validatedData['patient_user_id'] ?? $patientUserId; // Use a default value
                        $reportAdd->doctor_user_id = 2; // Use a default value
                        $reportAdd->mobile = $validatedData['mobile'];
                        $reportAdd->created_by = Auth::user()->id;
                        $reportAdd->no_of_visite = $visitCount;
                        $reportAdd->last_visited_date = $validatedData['subscript_date'];
                        $reportAdd->is_session_visite = 1;
                        $reportAdd->session_visite_count = $visitCount;
                        $reportAdd->save();

                        Log::info('ReviewReport created.', [
                            'patient_user_id' => $reportAdd->patient_user_id,
                            'no_of_visite' => $reportAdd->no_of_visite
                        ]);
                    };

                }

                return response()->json(['success' => $patientProfile]);
            } else {
                Log::error('Failed to save PatientProfile.');
                return response()->json(['error' => 'Something went wrong, please try again.']);
            }
        } catch (\Exception $e) {
            // Log the exception message
            Log::error('Exception occurred while storing data:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'An unexpected error occurred.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         // Find the patient by ID
         $patient = PatientProfile::findOrFail($id);

         // Delete the patient
         $patient->delete();

         // Optionally, you can redirect back with a success message
         return response()->json(['success', 'Patient deleted successfully!']);
    }
    public function  upozilla($id){
        $states = GeoUpazillas::where('geo_district_id', $id)->orderBy('upazila_name_eng', 'ASC')->get();
        return response()->json($states);
    }

}
