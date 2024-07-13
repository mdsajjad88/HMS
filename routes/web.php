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
    Route::get('/addDoctorView', [DoctorController::class, 'create'])->name('doctor.add');
    Route::post('/addDoctor', [DoctorController::class, 'store']);

    Route::get('/editDoctor/{id}', [DoctorController::class, 'edit']);
    Route::post('/updateDoctor', [DoctorController::class, 'update']);
    Route::get('/patient', [PatientController::class, 'index'])->name('patient');
    Route::get('/getPatient', [PatientController::class, 'getPatient'])->name('patient_profiles.index');
    Route::get('/addPatient', [PatientController::class, 'create'])->name('add.patient');
    Route::post('/addNewPatient', [PatientController::class, 'store']);
    Route::get('/editPatient/{id}', [PatientController::class, 'edit']);
    Route::delete('/deletePatient/{id}', [PatientController::class, 'destroy']);
    Route::get('/getOnePatient/{id}', [PatientController::class, 'getOnePatient']);
    Route::post('/updatePatient', [PatientController::class, 'update']);
    Route::delete('/deleteDoctor/{id}', [DoctorController::class, 'destroy']);
    Route::get('/doctor', [DoctorController::class, 'index'])->name('doctor');
    Route::get('/doctor_profiles', [DoctorController::class, 'show'])->name('doctor_profiles.index');
});

require __DIR__.'/auth.php';
