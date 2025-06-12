<?php

/*
use App\Http\Controllers\AppointmentController;
*/

use App\Http\Controllers\Api\AdminLogController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\ConnectionController;
use App\Http\Controllers\Api\StudentController;  // Met Api namespace
use App\Http\Controllers\Api\CompanyController;  // Met Api namespace
use Illuminate\Support\Facades\Mail;             // Mail
use Illuminate\Support\Facades\Route;            // Route
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\MailController;

// Mail routes
Route::post('/mail/{id}', [MailController::class, 'sendStudentVerification']);
Route::post('/mail/appointment/{id}', [MailController::class, 'AppointmentConfirmation']);

// Test route
Route::get('/test', function() {
    return response()->json(['message' => 'API works!']);
});

// student routes
Route::middleware('throttle:50,1')->group(function () {
    Route::get('/students', [StudentController::class, 'index']);
    Route::post('/students', [StudentController::class, 'store']);
    Route::get('/students/{id}', [StudentController::class, 'show']);
    Route::put('/students/{id}', [StudentController::class, 'update']);
    Route::delete('/students/{id}', [StudentController::class, 'destroy']);
});

// company routes
Route::middleware('throttle:50,1')->group(function () {
    Route::get('/companies', [CompanyController::class, 'index']);
    Route::post('/companies', [CompanyController::class, 'store']);
    Route::get('/companies/{id}', [CompanyController::class, 'show']);
    Route::put('/companies/{id}', [CompanyController::class, 'update']);
    Route::delete('/companies/{id}', [CompanyController::class, 'destroy']);
});

// appointment routes
Route::middleware('throttle:200,1')->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
    Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);
});
// connection routes
Route::middleware('throttle:50,1')->group(function () {
    Route::get('/connections', [ConnectionController::class, 'index']);
    Route::post('/connections', [ConnectionController::class, 'store']);
    Route::get('/connections/{id}', [ConnectionController::class, 'show']);
    Route::patch('/connections/{id}', [ConnectionController::class, 'update']);
    // hier een patch ipv een put omdat enkel het tijdstip wordt aangepast
    Route::delete('/connections/{id}', [ConnectionController::class, 'destroy']);
});

// Route::apiResource('appointments', AppointmentController::class);

// Admin routes voor logs
Route::get('/admin/logs', [AdminLogController::class, 'getLogs']);

//routes voor berichten
Route::post('/messages/send', [MessageController::class, 'sendMessage']);
Route::get('/messages/conversation', [MessageController::class, 'getConversation']);
