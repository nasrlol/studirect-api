<?php

/*
use App\Http\Controllers\AppointmentController;
*/

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\StudentController;  // Met Api namespace
use App\Http\Controllers\Api\CompanyController;  // Met Api namespace
use Illuminate\Support\Facades\Mail;             // Mail
use Illuminate\Support\Facades\Route;            // Route
use App\Http\Controllers\Api\AdminController;

// Mail routes
// momenteel is dit nog maar een test mail om aan te tonen dat de server werkt
// verdere implementatie moet nog gebeuren
Route::get('/mail',function(){
    Mail::raw('', function($message){
       $message->to('appie@nsrddyn.com')
           ->subject('Laravel Mail');
    });
        return response()->json(['message' => 'Mail works!']);
});

// Test route
Route::get('/test', function() {
    return response()->json(['message' => 'API works!']);
});


// student routes
Route::get('/students', [StudentController::class, 'index']);
Route::post('/students', [StudentController::class, 'store']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::delete('/students/{id}', [StudentController::class, 'destroy']);

// company routes
Route::get('/companies', [CompanyController::class, 'index']);
Route::post('/companies', [CompanyController::class, 'store']);
Route::get('/companies/{id}', [CompanyController::class, 'show']);
Route::put('/companies/{id}', [CompanyController::class, 'update']);
Route::delete('/companies/{id}', [CompanyController::class, 'destroy']);

// appointment routes
Route::get('/appointments', [AppointmentController::class, 'index']);
Route::post('/appointments', [AppointmentController::class, 'store']);
Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);


// zo kan het ook, misschien doen we het zo later
// Route::apiResource('appointments', AppointmentController::class);

 // Admin routes voor student beheer
Route::get('/admin/students', [AdminController::class, 'getAllStudents']);
Route::get('/admin/students/{id}', [AdminController::class, 'getStudent']);
Route::put('/admin/students/{id}', [AdminController::class, 'updateStudent']);
Route::delete('/admin/students/{id}', [AdminController::class, 'deleteStudent']);

// Admin routes voor bedrijf beheer
Route::get('/admin/companies', [AdminController::class, 'getAllCompanies']);
Route::get('/admin/companies/{id}', [AdminController::class, 'getCompany']);
Route::put('/admin/companies/{id}', [AdminController::class, 'updateCompany']);
Route::delete('/admin/companies/{id}', [AdminController::class, 'deleteCompany']);

// Admin routes voor logs
Route::get('/admin/logs', [AdminController::class, 'getLogs']);