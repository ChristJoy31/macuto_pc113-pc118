<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StudentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/employees/{$id}', [EmployeeController::class, 'search']);
Route::post('/employees', [EmployeeController::class, 'store']);
Route::post('/employees/{$id}', [EmployeeController::class, 'update']);
Route::delete('/employees/{$id}', [EmployeeController::class, 'destroy']);

Route::get('/students', [StudentController::class, 'index']);
Route::get('/students/{$id}', [StudentController::class, 'search']);
Route::post('/students', [StudentController::class, 'store']);
Route::post('/students/{$id}', [StudentController::class, 'update']);
Route::delete('/students/{$id}', [StudentController::class, 'destroy']);
