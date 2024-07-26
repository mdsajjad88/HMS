<?php

namespace App\Http\Controllers;

use App\Models\DoctorProfile;
use App\Models\MedicalTest;
use App\Models\PatientMedicalTest;
use App\Models\PatientProfile;
use App\Models\PatientUser;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
class PatientMedicalTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PatientMedicalTest::latest()->get(); // Fetch all doctor profiles
            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn = '<a  data-id="'.$row->id.'" class=" btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i>Edit</a>';
                    $btn .= ' <a  data-id="'.$row->id.'" class=" btn btn-danger btn-sm"><i class="fa-solid fa-trash-arrow-up"></i>Delete</a>';
                    return $btn;
                })
                ->addColumn('doctor_name', function($data) {
                    return $data->doctor->first_name; // Assuming 'name' is the column for doctor's name in 'users' table
                })
                ->addColumn('patient_name', function($data) {
                    return $data->patient->username; // Assuming 'name' is the column for doctor's name in 'users' table
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('patientTest.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = PatientUser::all();
        $doctors = DoctorProfile::all();
        $medicalTests = MedicalTest::all();
        return view('patientTest.create', compact('patients', 'doctors', 'medicalTests'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       //dd($request->all());
        $validatedData = $request->validate([
            'patient_user_id' => 'required',
            'doctor_profile_id' => 'required',
            'medical_test' => 'required|array',
            'status' => 'required',
            'types' => 'nullable|string',
            'collection_charge' => 'nullable|numeric',
            'others_discount' => 'nullable|numeric',
            'amount' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'final_total' => 'nullable|numeric',
            'paid_amount' => 'nullable|numeric',
            'payment_status' => 'required'
        ]);

        // Create a new PatientMedicalTest instance and save it
       $patientTest = new PatientMedicalTest();
       $patientTest->patient_user_id = $request->input('patient_user_id');
       $patientTest->doctor_profile_id = $request->input('doctor_profile_id');
       $patientTest->medical_test = $request->input('medical_test');
       $patientTest->status = $request->input('status');
       $patientTest->types = $request->input('types');
       $patientTest->collection_charge = $request->input('collection_charge');
       $patientTest->others_discount = $request->input('others_discount');
       $patientTest->amount = $request->input('amount');
       $patientTest->discount = $request->input('discount');
       $patientTest->final_total = $request->input('final_total');
       $patientTest->paid_amount = $request->input('paid_amount');
       $patientTest->payment_status = $request->input('payment_status');
       $patientTest->save();

        // Redirect or return a response
        return response()->json(['success'=>true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PatientMedicalTest $patientMedicalTest)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PatientMedicalTest $patientMedicalTest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PatientMedicalTest $patientMedicalTest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PatientMedicalTest $patientMedicalTest)
    {
        //
    }
}
