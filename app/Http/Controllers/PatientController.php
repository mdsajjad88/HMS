<?php

namespace App\Http\Controllers;

use App\Models\DoctorProfile;
use App\Models\GeoDistricts;
use App\Models\GeoUpazillas;
use Illuminate\Http\Request;
use App\Models\PatientProfile;
use App\Models\PatientUser;
use App\Models\Problem;
use finfo;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
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
            $data = PatientProfile::latest()->get(); // Fetch all doctor profiles
            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn = '<a  data-id="'.$row->id.'"  class="editPatient btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i>Edit</a>';
                    $btn .= ' </i><a  data-id="'.$row->id.'" class="deletePatient btn btn-danger btn-sm"><i class="fa-solid fa-trash-arrow-up"></i>Delete</a>';
                    return $btn;
                })
                ->addColumn('district_name', function($data) {
                    return $data->district->district_name_eng; // Example: Accessing patient's first name
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
        return view('patient.add', compact('districts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validatedData =  $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'nullable|email',
            'mobile' => 'required|digits:11|numeric',
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date',
            'age' => 'required|integer',
            'nid' => 'nullable|string',
            'marital_status' => 'required|in:Married,Unmarried,Other',
            'height_cm' => 'required|string',
            'weight_kg' => 'required|string',
            'blood_group' => 'required|string',
            'emergency_phone' => 'nullable|string',
            'emergency_relation' => 'nullable|string',
            'discount' => 'nullable|string',
            'address' => 'required|string',
            'geo_district_id' => 'required',
            'geo_upazila_id' => 'required',
            'profession' => 'nullable|string',
            'referral' => 'nullable|string',
        ]);
        $patientUser = new PatientUser();
        $patientUser->username = $request->input('first_name').$request->input('last_name');
        $patientUser->password = $request->input('date_of_birth');
        $patientUser->user_body = $request->input('address');
        $patientUser->created_by = Auth::user()->id;
        $patientUser->save();

        $patientUserId = $patientUser->id;

        // Now create a new PatientProfile and associate it with the PatientUser
        $patientProfile = new PatientProfile();
        $patientProfile->patient_user_id = $patientUserId; // Assign patient_user_id
        $patientProfile->created_by = Auth::user()->id; // Assign patient_user_id
        $patientProfile->created = now(); // Assign patient_user_id
        $patientProfile->modified = now(); // Assign patient_user_id
        $patientProfile->geo_district_id = $validatedData['geo_district_id']; // Assign patient_user_id
        $patientProfile->geo_upazila_id = $validatedData['geo_upazila_id']; // Assign patient_user_id

        $patientProfile->fill($validatedData); // Fill other validated data

        if($patientProfile->save()){
            return response()->json(['success'=>$patientProfile]);
        }
        else{
            return response()->json(['error'=>'Something wrong please try again.']);
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
        return view('patient.edit', compact('id', 'states', 'districts'));
    }
    public function  getOnePatient($id){
        $patient = PatientProfile::find($id);
        return response()->json(['data'=>$patient]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData =  Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'nullable|email',
            'mobile' => 'required|digits:11|numeric',
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date',
            'age' => 'required|integer',
            'nid' => 'nullable|string',
            'marital_status' => 'required|in:Married,Unmarried,Other',
            'height_cm' => 'required|string',
            'weight_kg' => 'required|string',
            'blood_group' => 'required|string',
            'emergency_phone' => 'nullable|string',
            'emergency_relation' => 'nullable|string',
            'discount' => 'nullable|string',
            'address' => 'required|string',
            'profession' => 'nullable|string',
            'referral' => 'nullable|string',
        ]);


        if ($validatedData->fails()) {
            return response()->json(['error' => $validatedData->errors()->first()], 400);
        }
        $id = $request->input('id');
        // Find the doctor profile to update
        $doctorProfile = PatientProfile::findOrFail($id);

        // Update profile fields
        $doctorProfile->fill($request->all());
        try {
            $doctorProfile->save();
            return response()->json(['success' => 'Patient profile updated successfully.', 'doctor' => $doctorProfile], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
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
