<?php

//use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dit leidt de api naar index.blade.php, terwijl we de json eigenlijk zouden moeten opvragen
// Route::get('/students', [StudentController::class, 'index']);
// Route::post('/students', [StudentController::class, 'store']);
