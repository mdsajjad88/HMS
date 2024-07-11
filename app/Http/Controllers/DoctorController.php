<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorProfile;
use App\Models\PatientProfile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class DoctorController extends Controller
{
    public function  index(){
        return view('doctor.add');
    }
    public function store(Request $request){
      // dd($request->all());
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'mobile' => 'required|digits:11|numeric',
            'gender' => 'required|in:Male,Female,Other',
            'bmdc_number' => 'nullable|string',
            'blood_group' => 'required|string',
            'date_of_birth' => 'required|date',
            'nid' => 'required|string',
            'specialist' => 'required|string',
            'fee' => 'required|numeric',
            'designation' => 'required|string',
            'consultant_type' => 'nullable|string',
            'address' => 'nullable|string',
            'description' => 'nullable|string', // 2MB max
        ]);

        // Handle file upload (if photo is uploaded)
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/photos', $fileName);
            $validatedData['photo'] = $fileName;
        }

    if(DoctorProfile::create($validatedData)){
        return response()->json(['success'=>'Doctor Added successfully.']);
    }
    else{
        return response()->json(['error'=>'Something wrong please try again.']);
    }


    }
    public function show(){
        $doctors = DoctorProfile::all();
        return response()->json(['data'=>$doctors]);
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
            'last_name' => 'required|string',
            'email' => 'required|email',
            'mobile' => 'required|digits:11|numeric',
            'gender' => 'required|in:Male,Female,Other',
            'bmdc_number' => 'nullable|string',
            'blood_group' => 'required|string',
            'date_of_birth' => 'required|date',
            'nid' => 'required|string',
            'specialist' => 'required|string',
            'fee' => 'required|numeric',
            'designation' => 'required|string',
            'consultant_type' => 'nullable|string',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        // Find the doctor profile to update
        $doctorProfile = DoctorProfile::findOrFail($id);

        // Update profile fields
        $doctorProfile->fill($request->all());

        // Handle file upload (if photo is uploaded)
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Store the new file in the storage directory
            $path = $file->storeAs('public/photos', $fileName);

            // Check if file was stored successfully
            if (!$path) {
                return response()->json(['error' => 'Failed to store the photo.'], 500);
            }

            // Delete old photo if exists
            if ($doctorProfile->photo) {
                Storage::delete('public/photos/' . $doctorProfile->photo);
            }

            // Update photo field with new file name
            $doctorProfile->photo = $fileName;
        }

        // Save the updated doctor profile
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
}
