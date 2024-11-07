<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
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
        return view('comment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        try {
            // Create a new Comment instance and save it
            $comment = new Comment();
            $comment->name = $request->input('name');
            $comment->description = $request->input('description');
            $comment->save();

            // Prepare success response
            $output = [
                'success' => true,
                'msg' => 'Comment added successfully',
                'comment' => $comment,
            ];
        } catch (\Exception $e) {
            // Handle any errors that may occur
            $output = [
                'success' => false,
                'msg' => 'An error occurred while adding the comment: ' . $e->getMessage(),
            ];
        }

        // Return the response as JSON
        return response()->json($output); // Ensure the response is JSON
    }


    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }


    public function commentWisePatient(Request $request)
    {
        // Log initial request information
        Log::info('commentWisePatient method called', [
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date'),
            'comment_id' => $request->get('comment_id'),
        ]);
        DB::statement("SET SESSION group_concat_max_len = 1000000");

        if ($request->ajax()) {
            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');

            // Log the dates that are being used in the query
            Log::info('Processing Ajax request with date range', [
                'start_date' => $startDate,
                'end_date' => $endDate
            ]);

            // Build the query for comments
            $commentsQuery = DB::table('comments')
                ->join('report_and_comments', 'report_and_comments.comment_id', '=', 'comments.id')
                ->join('review_reports', 'review_reports.id', '=', 'report_and_comments.review_report_id')
                ->leftJoin('patient_users', 'patient_users.id', '=', 'review_reports.patient_user_id')
                ->leftJoin('patient_profiles', 'patient_profiles.patient_user_id', '=', 'patient_users.id')
                ->select(
                    'comments.id as comment_id',
                    DB::raw("CONCAT(comments.name, ' (', COUNT(patient_users.id), ')') as comment_name_with_count"),
                    'comments.description as comment_description',
                    DB::raw("GROUP_CONCAT(CONCAT(patient_users.username, ' (', patient_profiles.mobile, '/', review_reports.last_visited_date, ')') SEPARATOR ', ') as patient_info"),
                    DB::raw("COUNT(patient_users.id) as patient_count")
                )
                ->groupBy('comments.id', 'comments.name', 'comments.description');

            // Log the query before adding any filters
            Log::info('Base query built', [
                'sql' => $commentsQuery->toSql(),
                'bindings' => $commentsQuery->getBindings()
            ]);

            // Apply filters based on comment_id, start_date, and end_date
            if ($request->has('comment_id') && $request->comment_id != '') {
                $commentsQuery->where('comments.id', $request->comment_id);
                Log::info('Filtering by comment_id', ['comment_id' => $request->comment_id]);
            }

            if ($startDate && $endDate) {
                $commentsQuery->whereBetween('review_reports.last_visited_date', [$startDate, $endDate]);
                Log::info('Filtering by date range', ['start_date' => $startDate, 'end_date' => $endDate]);
            } elseif ($startDate) {
                $commentsQuery->where('review_reports.last_visited_date', '>=', $startDate);
                Log::info('Filtering by start date', ['start_date' => $startDate]);
            } elseif ($endDate) {
                $commentsQuery->where('review_reports.last_visited_date', '<=', $endDate);
                Log::info('Filtering by end date', ['end_date' => $endDate]);
            }

            // Execute the query
            $comments = $commentsQuery->get();

            // Log the result of the query
            Log::info('Query executed, number of comments fetched', [
                'comments_count' => $comments->count(),
            ]);

            return datatables()->of($comments)
                ->addColumn('patient_info', function ($comment) {
                    // Log when a patient info is processed
                    Log::info('Processing patient_info for comment', ['comment_id' => $comment->comment_id, 'patient_info' => $comment->patient_info]);
                    return $comment->patient_info ?: 'No Patients';
                })
                ->rawColumns(['patient_info'])
                ->make(true);
        }

        // Log when the page view is being returned (non-ajax request)
        Log::info('Returning comment view for non-ajax request');

        $comments = Comment::all();
        return view('comment.comment_wise_patient', compact('comments'));
    }

}
