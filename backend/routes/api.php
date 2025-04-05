<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserDashboardController;



Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/employees/search', [EmployeeController::class, 'search']);
Route::post('/employees', [EmployeeController::class, 'store']);
Route::put('/employees/{id}', [EmployeeController::class, 'update']);
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);

Route::post('/login', [UserController::class, 'login']);



Route::get('/students', [StudentController::class, 'index']);
Route::get('/students/{id}', [StudentController::class, 'search']);
Route::post('/students', [StudentController::class, 'store']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::delete('/students/{id}', [StudentController::class, 'destroy']);


Route::middleware(['auth:sanctum', 'role:1'])->group(function() {
    Route::get('/users-admin', [UserController::class, 'admin']);
});

Route::middleware(['auth:sanctum', 'role:2'])->group(function() {
    Route::get('/user-dashboard', [UserDashboardController::class, 'index']); 
});