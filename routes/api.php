<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StudentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/employees', [EmployeeController::class, 'search']);

Route::get('/students', [StudentController::class, 'index']);
Route::get('/students', [StudentController::class, 'search']);
