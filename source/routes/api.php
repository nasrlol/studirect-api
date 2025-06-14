<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ConnectionController;
use App\Http\Controllers\Api\LogController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Support\Facades\Route;

// Student routes
Route::middleware('throttle:50,1')->group(function () {
    Route::get('/students', [StudentController::class, 'index']);
    Route::post('/students', [StudentController::class, 'store']);
    Route::get('/students/{id}', [StudentController::class, 'show']);
    Route::put('/students/{id}', [StudentController::class, 'update']);
    Route::delete('/students/{id}', [StudentController::class, 'destroy']);
    Route::patch('/students/{id}', [StudentController::class, 'partialUpdate']);
});

// Company routes
Route::middleware('throttle:50,1')->group(function () {
    Route::get('/companies', [CompanyController::class, 'index']);
    Route::post('/companies', [CompanyController::class, 'store']);
    Route::get('/companies/{id}', [CompanyController::class, 'show']);
    Route::put('/companies/{id}', [CompanyController::class, 'update']);
    Route::delete('/companies/{id}', [CompanyController::class, 'destroy']);
    Route::patch('companies/{id}', [CompanyController::class, 'partialUpdate']);
});

// Appointment routes
Route::middleware('throttle:200,1')->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
    Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);
});

// Connection routes
Route::middleware('throttle:50,1')->group(function () {
    Route::get('/connections', [ConnectionController::class, 'index']);
    Route::post('/connections', [ConnectionController::class, 'store']);
    Route::get('/connections/{id}', [ConnectionController::class, 'show']);
    Route::patch('/connections/{id}', [ConnectionController::class, 'update']);
    // hier een patch in plaats van een put omdat enkel het tijdstip wordt aangepast
    Route::delete('/connections/{id}', [ConnectionController::class, 'destroy']);
});

// Route::apiResource('appointments', AppointmentController::class);

// Admin routes voor logs
Route::get('/admin/logs', [LogController::class, 'getLogs']);

// Routes voor berichten
Route::post('/messages/send', [MessageController::class, 'sendMessage']);
Route::get('/messages/conversation', [MessageController::class, 'getConversation']);
