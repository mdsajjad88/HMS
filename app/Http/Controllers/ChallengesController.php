<?php

namespace App\Http\Controllers;

use App\Models\Challenges;
use Illuminate\Http\Request;

class ChallengesController extends Controller
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
        return view('challenges.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:challenges,name,',
        ]);
        $challenge = new Challenges();
        $challenge->name = $request->input('name');
        $challenge->description = $request->input('description');
        $challenge->save();
        return response()->json(['challenge'=>$challenge]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Challenges $challenges)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Challenges $challenges)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Challenges $challenges)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Challenges $challenges)
    {
        //
    }
}
