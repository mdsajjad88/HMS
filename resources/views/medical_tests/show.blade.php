@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Medical Test Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $medicalTest->name }}
                        </div>
                        <div class="form-group">
                            <strong>Types:</strong>
                            {{ $medicalTest->types }}
                        </div>
                        <div class="form-group">
                            <strong>Description:</strong>
                            {{ $medicalTest->description }}
                        </div>
                        <div class="form-group">
                            <strong>Price:</strong>
                            {{ $medicalTest->price }}
                        </div>
                        <!-- Add more fields as needed -->
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-primary" href="{{ route('medical-tests.index') }}"> Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
