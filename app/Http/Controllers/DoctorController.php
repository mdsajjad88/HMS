<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorProfile;
use App\Models\User;
use App\Models\PatientProfile;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function index(){
        return view('doctor.index');
    }
    public function  create(){
        return view('doctor.add');
    }
    public function store(Request $request){
      // dd($request->all());
           // try {
                $validatedata = $request->validate([
                    'first_name' => 'required|string',
                    'last_name' => 'required|string',
                    'email' => 'required|email|unique:doctor_profiles,email',
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
                ],[
                    'email.unique'=>'Sorry!  This email already have taken !!!'
                ]);

                $doctor = new User();
                $doctor->name = $request->input('first_name').' '.$request->input('last_name');
                $doctor->email  = $request->input('email');
                $doctor->email_verified_at = now();
                $doctor->password = $request->mobile;
                $doctor->save();

                $doctorID = $doctor->id;

                // Now create a new PatientProfile and associate it with the PatientUser
                $doctorProfile = new DoctorProfile();
                $doctorProfile->user_id  = $doctorID; // Assign patient_user_id
                $doctorProfile->fill($validatedata);
                $doctorProfile->save();
                return response()->json(['success' => true]);
        }
        public function show(Request $request){
            if ($request->ajax()) {
                $data = DoctorProfile::latest()->get(); // Fetch all doctor profiles
                return DataTables::of($data)
                    ->addColumn('action', function($row){
                        $btn = '<a  data-id="'.$row->id.'" class="editDoctor btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i>Edit</a>';
                        $btn .= ' <a  data-id="'.$row->id.'" class="deleteDoctor btn btn-danger btn-sm"><i class="fa-solid fa-trash-arrow-up"></i>Delete</a>';
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
            'last_name' => 'required|string',
            'email' => 'required|email|unique:doctor_profiles,email,'.$id,
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

