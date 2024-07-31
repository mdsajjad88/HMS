@extends('layouts.app')
@section('title', 'Patients')
@section('content')
<style>
    body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }
    #userName{
            font-family: 'cursive';
            text-transform: uppercase;
            text-align: center;
            font-size: 8rem;
            color: #2c3e50; /* Darker text color for contrast */
            text-shadow: 4px 4px 8px rgba(0, 0, 0, 0.4), 0 0 25px rgba(0, 0, 0, 0.2); /* Soft shadow effect */
            letter-spacing: 0.1em; /* Spacing between letters */
            font-weight: bold;
            background: linear-gradient(145deg, #ffffff, #f1f1f1); /* Gradient background */
            -webkit-background-clip: text; /* Clips the gradient to the text */
            border-radius: 8px; /* Optional: Rounded corners */
            padding: 10px 20px; /* Padding around the text */
        }
    #userName:hover{
            color: #000000; /* Darker text color for contrast */
            text-shadow: 4px 4px 4px 4px rgba(63, 102, 180, 0.4), 0 0 25px rgba(23, 23, 158, 0.2); /* Soft shadow effect */
            background: linear-gradient(145deg, #ffffff, #f1f1f1); /* Gradient background */
        }
</style>

<div class="container mt-5">
    <div class="row">
        <div class="col">
            <h1 id="userName">Welcome <br> Dear,  {{Auth::user()->name}}</h1>
        </div>
    </div>
</div>
@endsection
