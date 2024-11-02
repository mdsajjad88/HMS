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
}
