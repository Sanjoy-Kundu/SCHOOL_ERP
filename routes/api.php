<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ForgotPasswordController;
use Illuminate\Support\Facades\Route;




  /*
|--------------------------------------------------------------------------
| API Routes (Stateful Web AJAX and Stateless Mobile/External support)
|--------------------------------------------------------------------------
*/

Route::middleware('web')->group(function () {
    
    /* ----------------------------------------
       PUBLIC AUTH API ROUTE GATEWAY
    -------------------------------------------*/
    // Fixed: Changed 'store' to 'login' to match your AuthController
    Route::post('/auth/login', [AuthController::class, 'store'])->name('api.auth.login');
    
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('api.password.email');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('api.password.update');
});

/* ----------------------------------------
   PROTECTED API ROUTES (Sanctum Token Authentication)
-------------------------------------------*/
Route::middleware('auth:sanctum')->group(function () {
    // Shared route endpoint for profile details (Cleaned duplicates)
    Route::get('/auth/details', [AuthController::class, 'details'])->name('api.auth.details');
});












// // Protected API routes using Laravel Sanctum middleware
// Route::middleware('auth')->group(function () {
//     Route::get('/auth/details', [AuthController::class, 'details']);
// });


// Route::middleware('web')->group(function () {
// /* ----------------------------------------
//     PUBLIC AUTH ROUTES
// -------------------------------------------*/

// Route::post('/auth/login', [AuthController::class, 'store'])->name('api.auth.login');
// Route::get('/auth/details', [AuthController::class, 'details'])->name('api.auth.details');
// Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('api.password.email');
// Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('api.password.update');




//   });




