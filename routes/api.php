<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ForgotPasswordController;
use Illuminate\Support\Facades\Route;





// Protected API routes using Laravel Sanctum middleware
Route::middleware('auth')->group(function () {
    Route::get('/auth/details', [AuthApiController::class, 'details']);
});


Route::middleware('web')->group(function () {
/* ----------------------------------------
    PUBLIC AUTH ROUTES
-------------------------------------------*/

Route::post('/auth/login', [AuthApiController::class, 'store'])->name('api.auth.login');
Route::get('/auth/details', [AuthApiController::class, 'details'])->name('api.auth.details');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('api.password.email');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('api.password.update');




  });