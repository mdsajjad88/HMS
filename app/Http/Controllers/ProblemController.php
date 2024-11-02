<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Problem;
use App\Models\ReviewReport;
class ProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('problem.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:problems,name',
        ]);
        $problem = new Problem();
        $problem->name = $request->input('name');
        $problem->description = $request->input('description');
        $problem->save();
        return response()->json(['problem'=>$problem]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function problemWisePatient(Request $request) {
        if ($request->ajax()) {
            $problems = Problem::with(['reports.patient.profile'])->get(); // Eager load reports, patients, and their profiles

            return datatables($problems)
                ->addColumn('patient_info', function ($problem) {
                    // Use a collection to store unique patients
                    $uniquePatients = collect();

                    // Collect patient info from reports
                    foreach ($problem->reports as $report) {
                        $patient = $report->patient;
                        if ($patient) {
                            $profile = $patient->profile; 
                            $key = $patient->id;
                            if (!$uniquePatients->has($key)) {
                                $uniquePatients->put($key, $profile ? "{$patient->username} ({$profile->mobile})" : 'No Profile');
                            }
                        }
                    }

                    return $uniquePatients->values()->implode(', ') ?? 'No Patients'; // Return unique patients
                })
                ->rawColumns(['patient_info'])
                ->make(true); // Ensure to call make(true) to return JSON response
        }

        return view('problem.problem_wise_patient');
    }

}
