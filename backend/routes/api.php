<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\DocumentController;


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

Route::middleware('auth:sanctum')->get('/user-info', function (Request $request) {
    return response()->json([
        'name' => $request->user()->first_name,
        'role' => $request->user()->role
    ]);
});
Route::middleware('auth:sanctum')->get('/user-profile', [UserController::class, 'profile']);

Route::middleware(['auth:sanctum', 'role:1'])->group(function() {
    // Route::get('/users-admin', [UserController::class, 'admin']);
    Route::get('/users-admin', [UserController::class, 'show']);
    Route::get('/users-admin/{id}', [UserController::class, 'search']);
    Route::post('/users-admin', [UserController::class, 'store']);
    Route::put('/users-admin/{id}', [UserController::class, 'update']);
    Route::delete('/users-admin/{id}', [UserController::class, 'destroy']);
    Route::post('upload-document', [DocumentController::class, 'store']);
Route::get('list-documents', [DocumentController::class, 'index']);
Route::post('delete-document', [DocumentController::class, 'destroy']);

  

    
});

Route::middleware(['auth:sanctum', 'role:2'])->group(function() {
    Route::get('/user-dashboard', [UserDashboardController::class, 'index']); 
});