<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ConnectionController;
use App\Http\Controllers\Api\DiplomaController;
use App\Http\Controllers\Api\LogController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\Auth\CompanyAuthController;
use App\Http\Controllers\Api\Auth\StudentAuthController;

// Student routes
Route::middleware('throttle:300,1')->group(function () {
    Route::get('/students', [StudentController::class, 'index']);
    Route::post('/students', [StudentController::class, 'store']);
    Route::get('/students/{id}', [StudentController::class, 'show']);
    Route::put('/students/{id}', [StudentController::class, 'update']);
    Route::delete('/students/{id}', [StudentController::class, 'destroy']);
    Route::get('/students/{id}/verify', [StudentController::class, 'verify'])
        ->name('students.verify') // maak een naam voor de route, kan ik die straks makkelijker aanroepen in de mail view
        ->middleware('signed');
    Route::patch('/students/{id}', [StudentController::class, 'partialUpdate']);
});

// Company routes
Route::middleware('throttle:300,1')->group(function () {
    Route::get('/companies', [CompanyController::class, 'index']);
    Route::post('/companies', [CompanyController::class, 'store']);
    Route::get('/companies/{id}', [CompanyController::class, 'show']);
    Route::put('/companies/{id}', [CompanyController::class, 'update']);
    Route::delete('/companies/{id}', [CompanyController::class, 'destroy']);
    Route::patch('companies/{id}', [CompanyController::class, 'partialUpdate']);
});

// Appointment routes
Route::middleware('throttle:500,1')->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
    Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);
});

// Connection routes
Route::middleware('throttle:500,1')->group(function () {
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
Route::get('admin/logs/students/{id}', [LogController::class, 'getLogsStudent']);
Route::get('admin/logs/companies/{id}', [LogController::class, 'getLogsCompany']);
Route::get('admin/logs/admins/{id}', [LogController::class, 'getLogsAdmin']);

Route::get('/diplomas', [DiplomaController::class, 'index']);
Route::get('/diplomas/{id}', [DiplomaController::class, 'show']);

// Routes voor berichten
Route::post('/messages/send', [MessageController::class, 'sendMessage']);
//Route::get('/messages/conversation', [MessageController::class, 'getConversation']);

Route::post('/messages/conversation', [MessageController::class, 'getConversation']);


// Authentication Routes
Route::post('/students/login', [StudentAuthController::class, 'login']);
Route::post('/companies/login', [CompanyAuthController::class, 'login']);
Route::post('/admins/login', [AdminAuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    // Logout routes
    Route::post('/students/logout', [StudentAuthController::class, 'logout']);
    Route::post('/companies/logout', [CompanyAuthController::class, 'logout']);
    Route::post('/admins/logout', [AdminAuthController::class, 'logout']);

    // You can protect other routes here as needed
    // For example:
    // Route::get('/protected-resource', [YourController::class, 'method']);
});

Route::post('/students/{id}/reset/mail', [PasswordResetController::class, 'sendResetStudentPassword'])
    ->middleware('signed');

Route::patch('/students/{id}/reset', [PasswordResetController::class, 'resetStudentPassword'])
    ->name('students.resetPassword')
    ->middleware('signed');
