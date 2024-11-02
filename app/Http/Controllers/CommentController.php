<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

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
    public function commentmWisePatient(Request $request){
            if ($request->ajax()) {
                $comments = Comment::with(['reports.patient.profile'])->get(); // Eager load reports, patients, and their profiles

                return datatables($comments)
                    ->addColumn('patient_info', function ($comment) {
                        // Use a collection to store unique patients
                        $uniquePatients = collect();

                        // Collect patient info from reports
                        foreach ($comment->reports as $report) {
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

            return view('comment.comment_wise_patient');

    }
}
