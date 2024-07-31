<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalTestController;
use App\Http\Controllers\ReviewReportController;
use App\Http\Controllers\PatientMedicalTestController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
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
    Route::get('/viewDoctor/{id}/{days}', [DoctorController::class, 'view']);

    Route::get('/doctor', [DoctorController::class, 'index'])->name('doctor');
    Route::get('/doctor_profiles', [DoctorController::class, 'show'])->name('doctor_profiles.index');

    Route::resource('medical-tests', MedicalTestController::class);
    Route::resource('patient-medical-tests', PatientMedicalTestController::class);
    Route::get('/tests/edit/{id}', [MedicalTestController::class, 'editview']);
    Route::resource('medical-report', ReviewReportController::class);
    Route::get('create/medical/report', [ReviewReportController::class, 'creating']);
    Route::get('latest/report/{id}', [ReviewReportController::class, 'latestReport']);
    Route::get('getupozilla/{id}', [PatientController::class, 'upozilla' ]);
    Route::resource('problems', ProblemController::class);

    Route::get('/medical-tests-list', [MedicalTestController::class, 'getMedicalTests'])->name('medical-tests.list');
    Route::resource('report', ReportController::class);
});

require __DIR__.'/auth.php';
