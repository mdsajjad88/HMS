<?php

namespace App\Http\Controllers;

use App\Models\MedicalTest;
use App\Models\User;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\Console;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class MedicalTestController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MedicalTest::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id. '" class="edit btn btn-primary btn-sm">Edit</a> ';
                    $btn .= '<a href="javascript:void(0)" data-id="'.$row->id. '" class="delete btn btn-danger btn-sm">Delete</a>';
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
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'sample_collection_room_number' => 'nullable|string|max:255',
            'lab_location_id' => 'required|integer|min:1',
            'status' => 'required',
            'discount_type' => 'nullable|string|max:255',
            'discount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        //MedicalTest::create($request->all());
        // return response()->json(['success' => 'Medical test created successfully.']);

        $test = new MedicalTest();
        $test->name = $request->input('name');
        $test->price = $request->input('price');
        $test->lab_location_id = $request->input('lab_location_id');
        $test->sample_collection_room_number = $request->input('sample_collection_room_number');
        $test->status = $request->input('status');
        $test->discount_type = $request->input('discount_type');
        $test->discount = $request->input('discount');
        $test->description = $request->input('description');
        $test->save();
        return response()->json(['success'=>true]);

    }

    public function show(MedicalTest $medicalTest)
    {
        return view('medical_tests.show', compact('medicalTest'));
    }

    public function editview(MedicalTest $medical_test, $id)
    {
        $test = MedicalTest::find($id);
        return view('medical_tests.edit', compact('test'));
    }

    public function update(Request $request, MedicalTest $medicalTest)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'sample_collection_room_number' => 'nullable|string|max:255',
            'lab_location_id' => 'required|integer|min:1',
            'status' => 'required',
            'discount_type' => 'nullable|string|max:255',
            'discount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $medicalTest->update($request->all());
        return response()->json(['success' => true]);
    }

    public function destroy(MedicalTest $medicalTest)
    {

        $medicalTest->delete();
        return response()->json(['success' => 'Medical test deleted successfully.']);
    }

}
