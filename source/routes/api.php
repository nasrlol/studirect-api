<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\Auth\CompanyAuthController;
use App\Http\Controllers\Api\Auth\StudentAuthController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ConnectionController;
use App\Http\Controllers\Api\DiplomaController;
use App\Http\Controllers\Api\LogController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Support\Facades\Route;

// Student routes

Route::post('/students', [StudentController::class, 'store']);
Route::get('/students/{id}/verify', [StudentController::class, 'verify'])
    ->name('students.verify') // maak een naam voor de route, kan ik die straks makkelijker aanroepen in de mail view
    ->middleware('signed');

Route::get('/students', [StudentController::class, 'index']);
Route::middleware(['auth:sanctum', 'ability:student,admin', 'throttle:300,1'])->group(function () {
    Route::get('/students/{id}', [StudentController::class, 'show']);
    Route::put('/students/{id}', [StudentController::class, 'update']);
    Route::delete('/students/{id}', [StudentController::class, 'destroy']);
    Route::patch('/students/{id}', [StudentController::class, 'partialUpdate']);
});

// Company routes
Route::middleware(['throttle:300,1'])->group(function () {
    Route::get('/companies', [CompanyController::class, 'index']);
});

Route::middleware(['auth:sanctum', 'ability:company,admin', 'throttle:300,1'])->group(function () {
    Route::post('/companies', [CompanyController::class, 'store']);
    Route::get('/companies/{id}', [CompanyController::class, 'show']);
    Route::put('/companies/{id}', [CompanyController::class, 'update']);
    Route::delete('/companies/{id}', [CompanyController::class, 'destroy']);
    Route::patch('companies/{id}', [CompanyController::class, 'partialUpdate']);
});

// Admin routes
Route::middleware(['auth:sanctum', 'ability:admin', 'throttle:1,1'])->group(function () {
    // Admin CRUD operations
    Route::get('/admins', [AdminController::class, 'index']);
    Route::post('/admins', [AdminController::class, 'store']);
    Route::get('/admins/{id}', [AdminController::class, 'show']);
    Route::put('/admins/{id}', [AdminController::class, 'update']);
    Route::delete('/admins/{id}', [AdminController::class, 'destroy']);
});

// Logs
Route::middleware(['auth:sanctum', 'ability:admin', 'throttle:50,1'])->group(function () {
    Route::get('/admin/logs', [LogController::class, 'getLogs']);
    Route::get('admin/logs/students/{id}', [LogController::class, 'getLogsStudent']);
    Route::get('admin/logs/companies/{id}', [LogController::class, 'getLogsCompany']);
    Route::get('admin/logs/admins/{id}', [LogController::class, 'getLogsAdmin']);
});

// Appointment routes
Route::middleware(['auth:sanctum', 'throttle:500,1'])->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
    Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);


    Route::get('/connections', [ConnectionController::class, 'index']);
    Route::post('/connections', [ConnectionController::class, 'store']);
    Route::get('/connections/{id}', [ConnectionController::class, 'show']);
    Route::patch('/connections/{id}', [ConnectionController::class, 'update']);
    // hier een patch in plaats van een put omdat enkel het tijdstip wordt aangepast
    Route::delete('/connections/{id}', [ConnectionController::class, 'destroy']);

    Route::get('/connections/student/{id}', [ConnectionController::class, 'showConnectionStudent']);
    Route::get('/connections/company/{id}', [ConnectionController::class, 'showConnectionCompany']);

    // Protected Logout Authenticatie
    Route::post('/students/logout', [StudentAuthController::class, 'logout']);
    Route::post('/companies/logout', [CompanyAuthController::class, 'logout']);
    Route::post('/admins/logout', [AdminAuthController::class, 'logout']);
    Route::post('/logout', [LoginController::class, 'logout']);
});

// Authenticatie mail routes
Route::post('/reset/mail/{id}', [PasswordResetController::class, 'sendResetStudentPassword']);

// Berichten
Route::post('/messages/send', [MessageController::class, 'sendMessage']);
Route::post('/messages/conversation', [MessageController::class, 'getConversation']);


Route::middleware('throttle:api')->group(function () {
    // Skills routes
    Route::get('/skills', [SkillController::class, 'index']);
    Route::get('/skills/{id}', [SkillController::class, 'show']);

    Route::post('/students/{id}/skills', [SkillController::class, 'attachToStudent']);
    Route::delete('/students/{id}/skills/{skill_id}', [SkillController::class, 'detachFromStudent']);
    Route::get('/students/{id}/skills', [SkillController::class, 'getStudentSkills']);

    Route::post('/companies/{id}/skills', [SkillController::class, 'attachToCompany']);
    Route::delete('/companies/{id}/skills/{skill_id}', [SkillController::class, 'detachFromCompany']);
    Route::get('/companies/{id}/skills', [SkillController::class, 'getCompanySkills']);

    // Calculate skill match percentage
    Route::get('/match/{student_id}/{company_id}', [SkillController::class, 'calculateMatch']);

    // Diplomas ophalen
    Route::get('/diplomas', [DiplomaController::class, 'index']);
    Route::get('/diplomas/{id}', [DiplomaController::class, 'show']);
});

// Authenticatie
Route::post('/students/login', [StudentAuthController::class, 'login'])->middleware('throttle:login');
Route::post('/companies/login', [CompanyAuthController::class, 'login'])->middleware('throttle:login');
Route::post('/admins/login', [AdminAuthController::class, 'login'])->middleware('throttle:login');
Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:login');

