<?php

namespace App\Http\Controllers;

use App\Models\DoctorProfile;
use Illuminate\Http\Request;
use App\Models\PatientProfile;
use App\Models\PatientUser;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\Validator;
class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = PatientProfile::all();
        return response()->json(['data'=>$patients]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patient.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validatedData =  $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'email' => 'required|email',
            'mobile' => 'required|digits:11|numeric',
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date',
            'nid' => 'nullable|string',
            'marital_status' => 'required|in:Married,Unmarried,Other',
            'height_cm' => 'required|string',
            'weight_kg' => 'required|string',
            'blood_group' => 'required|string',
            'emergency_phone' => 'nullable|string',
            'emergency_relation' => 'nullable|string',
            'discount' => 'nullable|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
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
        $patientProfile->created = now(); // Assign patient_user_id
        $patientProfile->modified = now(); // Assign patient_user_id
        $patientProfile->fill($validatedData); // Fill other validated data


        if($patientProfile->save()){
            return response()->json(['success'=>'Patient Added successfully.']);
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
        return view('patient.edit', compact('id'));
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
            'last_name' => 'nullable|string',
            'email' => 'required|email',
            'mobile' => 'required|digits:11|numeric',
            'gender' => 'required|in:Male,Female,Other',
            'date_of_birth' => 'required|date',
            'nid' => 'nullable|string',
            'marital_status' => 'required|in:Married,Unmarried,Other',
            'height_cm' => 'required|string',
            'weight_kg' => 'required|string',
            'blood_group' => 'required|string',
            'emergency_phone' => 'nullable|string',
            'emergency_relation' => 'nullable|string',
            'discount' => 'nullable|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
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
   
}