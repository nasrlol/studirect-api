<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ConnectionController;
use App\Http\Controllers\Api\DiplomaController;
use App\Http\Controllers\Api\LogController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\Auth\CompanyAuthController;
use App\Http\Controllers\Api\Auth\StudentAuthController;

// Public routes - accessible without authentication
Route::middleware('throttle:300,1')->group(function () {
    // Authentication Routes
    Route::post('/students/login', [StudentAuthController::class, 'login']);
    Route::post('/companies/login', [CompanyAuthController::class, 'login']);
    Route::post('/admins/login', [AdminAuthController::class, 'login']);
    
    // Registration Routes
    Route::post('/students', [StudentController::class, 'store']);
    Route::post('/companies', [CompanyController::class, 'store']);
    
    // Email verification
    Route::get('/students/{id}/verify', [StudentController::class, 'verify'])
        ->name('students.verify')
        ->middleware('signed');
    
    // Public information
    Route::get('/diplomas', [DiplomaController::class, 'index']);
    Route::get('/diplomas/{id}', [DiplomaController::class, 'show']);
});

// Protected Routes - require authentication
Route::middleware(['auth:sanctum', 'throttle:500,1'])->group(function () {
    // Common authenticated routes
    Route::post('/students/logout', [StudentAuthController::class, 'logout']);
    Route::post('/companies/logout', [CompanyAuthController::class, 'logout']);
    Route::post('/admins/logout', [AdminAuthController::class, 'logout']);
    
    // Messaging system - accessible to all authenticated users
    Route::post('/messages/send', [MessageController::class, 'sendMessage']);
    Route::post('/messages/conversation', [MessageController::class, 'getConversation']);
    
    // Student-specific routes
    Route::middleware('ability:student')->group(function () {
        Route::get('/students/{id}', [StudentController::class, 'show'])->middleware('can:view,App\Models\Student,id');
        Route::put('/students/{id}', [StudentController::class, 'update'])->middleware('can:update,App\Models\Student,id');
        Route::patch('/students/{id}', [StudentController::class, 'partialUpdate'])->middleware('can:update,App\Models\Student,id');
        Route::delete('/students/{id}', [StudentController::class, 'destroy'])->middleware('can:delete,App\Models\Student,id');
        
        // Student can view companies
        Route::get('/companies', [CompanyController::class, 'index']);
        Route::get('/companies/{id}', [CompanyController::class, 'show']);
        
        // Appointments and connections
        Route::post('/appointments', [AppointmentController::class, 'store']);
        Route::get('/appointments/{id}', [AppointmentController::class, 'show'])->middleware('can:view,App\Models\Appointment,id');
        Route::put('/appointments/{id}', [AppointmentController::class, 'update'])->middleware('can:update,App\Models\Appointment,id');
        Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy'])->middleware('can:delete,App\Models\Appointment,id');
        
        Route::post('/connections', [ConnectionController::class, 'store']);
        Route::get('/connections/{id}', [ConnectionController::class, 'show'])->middleware('can:view,App\Models\Connection,id');
        Route::patch('/connections/{id}', [ConnectionController::class, 'update'])->middleware('can:update,App\Models\Connection,id');
    });
    
    // Company-specific routes
    Route::middleware('ability:company')->group(function () {
        Route::get('/companies/{id}', [CompanyController::class, 'show'])->middleware('can:view,App\Models\Company,id');
        Route::put('/companies/{id}', [CompanyController::class, 'update'])->middleware('can:update,App\Models\Company,id');
        Route::patch('companies/{id}', [CompanyController::class, 'partialUpdate'])->middleware('can:update,App\Models\Company,id');
        Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->middleware('can:delete,App\Models\Company,id');
        
        // Companies can view students
        Route::get('/students', [StudentController::class, 'index']);
        Route::get('/students/{id}', [StudentController::class, 'show']);
        
        // Company appointments and connections
        Route::get('/appointments', [AppointmentController::class, 'index']);
        Route::get('/appointments/{id}', [AppointmentController::class, 'show'])->middleware('can:view,App\Models\Appointment,id');
        Route::get('/connections', [ConnectionController::class, 'index']);
    });
    
    // Admin-only routes
    Route::middleware('ability:admin')->group(function () {
        // Admin can manage all resources
        Route::get('/students', [StudentController::class, 'index']);
        Route::get('/companies', [CompanyController::class, 'index']);
        

        // Admin routes voor logs
        Route::get('/admin/logs', [LogController::class, 'getLogs']);
        Route::get('admin/logs/students/{id}', [LogController::class, 'getLogsStudent']);
        Route::get('admin/logs/companies/{id}', [LogController::class, 'getLogsCompany']);
        Route::get('admin/logs/admins/{id}', [LogController::class, 'getLogsAdmin']);
        
        // Admin can view all appointments and connections
        Route::get('/appointments', [AppointmentController::class, 'index']);
        Route::get('/connections', [ConnectionController::class, 'index']);
    });
});