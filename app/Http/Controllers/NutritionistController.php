<?php

namespace App\Http\Controllers;

use App\Models\Challenges;
use App\Models\Nutritionist;
use App\Models\NutritionistVisit;
use App\Models\User;
use App\Models\Problem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
class NutritionistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user(); // Get the currently authenticated user

            // Check user role and set up query
            if ($user->role === 'admin') {
                $data = Nutritionist::latest()->get(); // Fetch all doctor profiles
            } elseif ($user->role === 'nutritionist') {

                $startOfDay = Carbon::today();
                $endOfDay = Carbon::tomorrow();
                $data = Nutritionist::whereBetween('created_at', [$startOfDay, $endOfDay])
                    ->orderBy('id', 'DESC') // Records older than 24 hours
                    ->get();
            } else {
                $data = collect(); // Return an empty collection if the role is not recognized
            }


            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn = '<a  data-id="'.$row->id.'"  class="editNutritionist btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i>Edit</a>&nbsp;';
                    $btn .= '<a  data-id="'.$row->id.'" class="deleteNutritionist btn btn-danger btn-sm "><i class="fa-solid fa-trash"></i>Delete</a>';
                    $btn .= '&nbsp;<a  data-id="'.$row->id.'" class="viewNutritionist btn btn-info btn-sm "><i class="fa-solid fa-eye"></i>View</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);

        }

        return view('nutritionist.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('nutritionist.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'gender' => 'required|string',
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

        try {
            // Create a new User instance
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make('12345678');
            $user->role = 'nutritionist';
            $user->save();

            // Log user creation
            Log::info('User created with ID: ' . $user->id . ' and email: ' . $user->email);

            // Create a new Nutritionist instance
            $nutritionist = new Nutritionist();
            $nutritionist->user_id = $user->id;
            $nutritionist->created_by = Auth::user()->id;
            $nutritionist->fill($request->all());
            $nutritionist->save();

            // Log nutritionist profile creation
            Log::info('Nutritionist profile created with ID: ' . $nutritionist->id);

            // Return JSON response
            return response()->json(['success' => 'Nutritionist Profile Created Successfully']);

        } catch (\Exception $e) {
            // Log the error
            Log::error('Error creating Nutritionist profile. Error: ' . $e->getMessage());

            // Return JSON response with error message
            return response()->json(['success' => false, 'message' => 'An error occurred while creating the profile.'], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('nutritionist.view');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function profile($id, $days){

        Log::info('Fetching profile data', ['nutritionist_id' => $id, 'days' => $days]);

        $nutritionist = Nutritionist::find($id);

        if (!$nutritionist) {
            Log::error('Nutritionist not found', ['nutritionist_id' => $id]);
            return redirect()->back()->withErrors(['error' => 'Nutritionist not found']);
        }

        $nuid = $nutritionist->user_id;
        // Determine date range based on dropdown selection
        $endDate = now();
        $startDate = null;

        switch ($days) {
            case '1':
                $startDate = $endDate->copy()->subDays(30);
                break;
            case '2':
                $startDate = $endDate->copy()->subDays(60);
                break;
            case '9':
                $startDate = $endDate->copy()->subDays(90);
                break;
            case '12':
                $startDate = $endDate->copy()->subYear();
                break;
            case 'all':
                // For 'all', there's no start date restriction
                $startDate = null;
                break;
            default:
                $startDate = null; // Fallback for any unexpected values
                Log::warning('Unexpected days value', ['days' => $days]);
                break;
        }
        // Build the query
        $query = NutritionistVisit::with('problems')->where('nutritionist_user_id', $nuid);
        if ($startDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Log the query being executed
        Log::info('Executing query', ['query' => $query->toSql(), 'bindings' => $query->getBindings()]);
        $nutritionistVisits = $query->get();

        $problemsCount = $nutritionistVisits->flatMap(function($visit) {
            return $visit->problems;
        })->groupBy('id') // Group by problem ID
        ->map(function($problems) {
            return $problems->count();
        });
        $totalProblemCount = $problemsCount->sum();

        $problemsData = Problem::whereIn('id', $problemsCount->keys())->get()->map(function($problem) use ($problemsCount) {
            return [
                'name' => $problem->name,
                'problem_count' => $problemsCount->get($problem->id)
            ];
        });
        $challengeCount = $nutritionistVisits->flatMap(function($visit1) {
            return $visit1->challenges;
        })->groupBy('id') // Group by problem ID
        ->map(function($challenges) {
            return $challenges->count();
        });
        $totalChallengeCount = $challengeCount->sum();

        $challengeData = Challenges::whereIn('id', $challengeCount->keys())->get()->map(function($challenge) use ($challengeCount) {
            return [
                'name' => $challenge->name,
                'challenge_count' => $challengeCount->get($challenge->id)
            ];
        });

        $totalVisit = $query->count();
        $totaltime = $query->sum('visit_duration');
        $diet_plan_status = $query->sum('diet_plan_status');
        $total_diet_plan_satisfaction = $query->sum('diet_plan_satisfaction');
        $treatmentSum = $query->sum('treatment_satisfaction');

        $avgVisitTime = $totalVisit > 0 ? number_format($totaltime / $totalVisit, 2) : '0.00';
        $dietPlanAvg = $totalVisit > 0 ? number_format($diet_plan_status / $totalVisit, 2) : '0.00';
        $dietPlanSatisAvg = $totalVisit > 0 ? number_format($total_diet_plan_satisfaction / $totalVisit, 2) : '0.00';
        $treatmentSatisAvg = $totalVisit > 0 ? number_format($treatmentSum / $totalVisit, 2) : '0.00';

        $data = [
            'nutritionist' => $nutritionist,
            'totalVisit' => $totalVisit,
            'avgVisitTime'=> $avgVisitTime,
            'diet_plan_status'=> $dietPlanAvg,
            'dietPlanSatisAvg'=> $dietPlanSatisAvg,
            'treatmentSatisAvg'=> $treatmentSatisAvg,
            'start_date' => $startDate ? $startDate->format('Y-m-d') : 'N/A',
            'end_date' => $endDate->format('Y-m-d'),
            'problems' => $problemsData,
            'totalProblemCount' => $totalProblemCount,
            'challenges' => $challengeData,
            'challengeCount' => $totalChallengeCount,
            'nutritionistVisits' => $nutritionistVisits,

        ];

            // Log the results
            Log::info('Profile data fetched successfully', $data);

            // Pass the data array to the view
            return view('nutritionist.view', compact('data'));

    }
    public function edit($id)
    {
        $nutritionist = Nutritionist::find($id);
        return view('nutritionist.edit', compact('nutritionist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nutritionist $nutritionist)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'gender' => 'required|string',
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

       $id = $request->input('id');
        // Find the Nutritionist by ID
        $nutritionist = Nutritionist::find($id);

        if (!$nutritionist) {
            return response()->json(['success' => false, 'message' => 'Nutritionist not found'], 404);
        }

        // Update the nutritionist record
        $nutritionist->fill($validatedData);
        $nutritionist->save();

        // Update the associated user record if needed
        $user = User::find($nutritionist->user_id);
        if ($user) {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            // You can update the password or other user fields here if necessary
            $user->save();
        }

        // Log the update action
        Log::info("Nutritionist with ID $id updated by user ID " . Auth::user()->id);

        // Return a successful response
        return response()->json(['success' => true, 'message' => 'Nutritionist profile updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        try {
            // Find the Nutritionist item by its ID
            $item = Nutritionist::find($id);

            if ($item) {
                // Log the deletion attempt
                Log::info('Attempting to delete Nutritionist ID: ' . $id);

                // Delete the item
                $item->delete();

                // Log successful deletion
                Log::info('Successfully deleted Nutritionist ID: ' . $id);

                // Return JSON response for successful deletion
                return response()->json(['success' => true], 200);
            }

            // Log the item not found situation
            Log::warning('Nutritionist ID not found: ' . $id);

            // Return JSON response for item not found
            return response()->json(['success' => false, 'message' => 'Item not found'], 404);

        } catch (\Exception $e) {
            // Log any exceptions that occur
            Log::error('Error deleting Nutritionist ID: ' . $id . '. Error: ' . $e->getMessage());

            // Return JSON response for internal server error
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }
}
