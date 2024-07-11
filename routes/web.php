<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/addDoctorView', [DoctorController::class, 'index']);
    Route::post('/addDoctor', [DoctorController::class, 'store']);
    Route::get('/getDoctor', [DoctorController::class, 'show']);
    Route::get('/editDoctor/{id}', [DoctorController::class, 'edit']);
    Route::post('/updateDoctor', [DoctorController::class, 'update']);
    Route::get('/getPatient', [PatientController::class, 'index']);
    Route::get('/addPatient', [PatientController::class, 'create']);
    Route::post('/addNewPatient', [PatientController::class, 'store']);
    Route::get('/editPatient/{id}', [PatientController::class, 'edit']);
    Route::get('/getOnePatient/{id}', [PatientController::class, 'getOnePatient']);
    Route::post('/updatePatient', [PatientController::class, 'update']);
    Route::delete('/deleteDoctor/{id}', [DoctorController::class, 'destroy']);
});

require __DIR__.'/auth.php';
