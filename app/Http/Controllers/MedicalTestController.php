<?php

namespace App\Http\Controllers;

use App\Models\MedicalTest;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MedicalTestController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MedicalTest::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm">Edit</a> ';
                    $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $medicalTests = MedicalTest::get();
        return view('medical_tests.index' , compact('medicalTests'));
    }

    public function create()
    {
        return view('medical_tests.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // Add validation rules here based on your fields
        ]);

        MedicalTest::create($request->all());
        return response()->json(['success' => 'Medical test created successfully.']);
    }

    public function show(MedicalTest $medicalTest)
    {
        return view('medical_tests.show', compact('medicalTest'));
    }

    public function edit(MedicalTest $medicalTest)
    {
        return response()->json($medicalTest);
    }

    public function update(Request $request, MedicalTest $medicalTest)
    {
        $request->validate([
            // Add validation rules here based on your fields
        ]);

        $medicalTest->update($request->all());
        return response()->json(['success' => 'Medical test updated successfully.']);
    }

    public function destroy(MedicalTest $medicalTest)
    {
        $medicalTest->delete();
        return response()->json(['success' => 'Medical test deleted successfully.']);
    }
}
