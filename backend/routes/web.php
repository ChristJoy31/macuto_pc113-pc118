<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'studentD'])->name('student.dashboard');
    Route::get('/employee/dashboard', [EmployeeController::class, 'employeeD'])->name('employee.dashboard');
});