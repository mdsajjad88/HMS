<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reference;
use App\Models\ReviewReport;
use Illuminate\Support\Facades\Log; // Import the Log facade
use Illuminate\Support\Facades\DB;

class ReferenceController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {


            DB::listen(function ($query) {
                Log::info('SQL Query: ' . $query->sql);
                Log::info('Bindings: ' . implode(', ', $query->bindings));
                Log::info('Time: ' . $query->time . 'ms');
            });


            Log::info('AJAX request received', [
                'start_date' => $request->get('start_date'),
                'end_date' => $request->get('end_date'),
                'reference_id' => $request->get('reference_id'),
            ]);

            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');
            $referenceId = $request->get('reference_id');

            // Build the initial query with the necessary joins
            $referencesQuery = DB::table('references')
                ->leftJoin('review_reports', 'references.id', '=', 'review_reports.reference_id')
                ->leftJoin('patient_users', 'review_reports.patient_user_id', '=', 'patient_users.id')
                ->leftJoin('patient_profiles', 'patient_users.id', '=', 'patient_profiles.patient_user_id')
                ->select(
                    'references.id as reference_id',
                    'references.name as reference_name',
                    'review_reports.id as report_id',
                    'review_reports.last_visited_date',
                    'patient_users.id as patient_user_id',
                    'patient_users.username',
                    'patient_profiles.mobile'
                );

            if ($referenceId && $referenceId != '') {
                $referencesQuery->where('references.id', $referenceId);
                Log::info('Filtering by reference_id', ['reference_id' => $referenceId]);
            }

            if ($startDate && $endDate) {
                $referencesQuery->whereBetween('review_reports.last_visited_date', [$startDate, $endDate]);
                Log::info('Filtering by date range', ['start_date' => $startDate, 'end_date' => $endDate]);
            } elseif ($startDate) {
                $referencesQuery->where('review_reports.last_visited_date', '>=', $startDate);
                Log::info('Filtering by start_date', ['start_date' => $startDate]);
            } elseif ($endDate) {
                $referencesQuery->where('review_reports.last_visited_date', '<=', $endDate);
                Log::info('Filtering by end_date', ['end_date' => $endDate]);
            }

            // Get the raw data
            $references = $referencesQuery->get();
            Log::info('Fetched references', ['count' => $references->count()]);

            $groupedReferences = $references->groupBy('reference_id')->map(function ($group) {
                $referenceName = $group->first()->reference_name;
                $uniquePatients = collect();

                foreach ($group as $item) {
                    $patientKey = $item->patient_user_id;
                    if (!$uniquePatients->has($patientKey)) {
                        $uniquePatients->put($patientKey, "{$item->username}" . ($item->mobile ? " ({$item->mobile})" : ""));
                    }
                }

                // Count the unique patients
                $patientsInfo = $uniquePatients->count() > 0 ? $uniquePatients->values()->implode(', ') : 'No Patients';
                $totalPatients = $uniquePatients->count() ?: 0;
                Log::info("Total Patients for $referenceName: $totalPatients");

                $referenceNameWithCount = $totalPatients > 0
                    ? ucfirst("{$referenceName} ({$totalPatients})")
                    : "{$referenceName} (No Patients)";
                Log::info('referenceNameWithCount: ' . $referenceNameWithCount); // Log the value for debugging


                // Return the data for this reference
                return [
                    'reference_name' => $referenceName,
                    'patients' => $patientsInfo,
                    'total_patients' => $totalPatients,
                    'reference_name_with_count' => $referenceNameWithCount,
                ];
            });

            return datatables()->of($groupedReferences)
                ->addColumn('patient_info', function ($reference) {
                    return $reference['patients'] ?: 'No Patients';
                })
                ->addColumn('reference_name_with_count', function ($reference) {
                    return $reference['reference_name_with_count'];
                })
                ->rawColumns(['patient_info', 'reference_name_with_count'])
                ->make(true);
        }

        $references = Reference::all();
        return view('reference.index', compact('references'));
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
}
