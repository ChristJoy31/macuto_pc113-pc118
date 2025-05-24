<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;


Route::post('/login', [AuthController::class, 'login']);
 Route::post('/set-password', [UserController::class, 'setPassword']);
 Route::post('/forgot-password', [AuthController::class, 'sendResetLink']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);



Route::get('/user-infos', [UserController::class, 'getUserInfo']);


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
    Route::post('/users-admin/{id}', [UserController::class, 'update']);
    Route::delete('/users-admin/{id}', [UserController::class, 'destroy']);
    Route::post('upload-document', [DocumentController::class, 'store']);
    Route::get('list-documents', [DocumentController::class, 'index']);
    Route::post('delete-document', [DocumentController::class, 'destroy']);
   

    

});

Route::middleware(['auth:sanctum', 'role:2'])->group(function() {
    Route::get('/certificate-request', [CertificateController::class, 'index']);
    Route::put('/certificate-request/{id}/status', [CertificateController::class, 'updateStatus']);
    

});





Route::middleware(['auth:sanctum', 'role:3'])->group(function() {
    Route::get('/user-dashboard', [UserDashboardController::class, 'index']);
    Route::post('/certificate-request', [CertificateController::class, 'store']);
    Route::get('/my-certificate-requests', [CertificateController::class, 'myRequests']);
    Route::put('/certificate-request/{id}/claim', [CertificateController::class, 'markAsClaimed']);


});





