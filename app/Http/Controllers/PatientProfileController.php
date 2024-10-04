<?php

namespace App\Http\Controllers;

use App\Models\DoctorProfile;
use Illuminate\Http\Request;
use App\Models\GeoDistricts;
use App\Models\PatientProfile;
use App\Models\GeoUpazillas;
use App\Models\ReviewReport;
use App\Models\PatientSubscription;
use App\Models\ReportAndProblem;
use App\Models\Problem;
use Illuminate\Support\Facades\DB;

class PatientProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $patientProfile = PatientProfile::find($id);
        $userId = $patientProfile->patient_user_id;
        $reports = ReviewReport::with('doctor')->where('patient_user_id', $userId)->get();
        $lastReport = ReviewReport::where('patient_user_id', $userId)->latest('created_at')->first();

        $subscript = PatientSubscription::where('patient_user_id', $userId)->first();
      
        $bd_medicine = $reports->sum('bd_medicine');
        $us_medicine = $reports->sum('us_medicine');
        $no_of_test = $reports->sum('no_of_test');
        $firstVisit = ReviewReport::where('patient_user_id', $userId)->first();
        $problems = Problem::take(5)->get();
        $noOfVisit = ReviewReport::where('patient_user_id', $id)->count();
        $total_improvement = ReviewReport::where('patient_user_id', $id)->count('physical_improvement');
        $yes_improvement = ReviewReport::where('patient_user_id', $id)->where('physical_improvement', 1)->count();

        $no_of_ozone_therapy = $reports->sum('no_of_ozone_therapy');
        $no_of_hijama_therapy = $reports->sum('no_of_hijama_therapy');
        $on_of_acupuncture = $reports->sum('on_of_acupuncture');
        $no_of_sauna = $reports->sum('no_of_sauna');
        $no_of_phototherapy = $reports->sum('no_of_phototherapy');
        $no_of_physiotherapy = $reports->sum('no_of_physiotherapy');
        $no_of_coffee_anema = $reports->sum('no_of_coffee_anema');

        $problems = ReportAndProblem::select('problems.name', DB::raw('count(report_and_problems.problem_id) as problem_count'))
        ->join('problems', 'report_and_problems.problem_id', '=', 'problems.id')
        ->where('patient_user_id', $userId) // Change to 'doctor_user_id' if needed
        ->groupBy('problems.name')
        ->get();


        $totalTherapy = $no_of_ozone_therapy + $no_of_hijama_therapy + $on_of_acupuncture + $no_of_sauna + $no_of_phototherapy + $no_of_physiotherapy + $no_of_coffee_anema;


        return view('patient.profile', compact('patientProfile', 'firstVisit', 'reports', 'noOfVisit','bd_medicine', 'us_medicine', 'no_of_test', 'totalTherapy', 'total_improvement', 'yes_improvement', 'lastReport', 'subscript',  'problems'));
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
}
