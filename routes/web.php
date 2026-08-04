<?php
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\EmailVerificationController;
use App\Http\Controllers\Web\ForgotPasswordController;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------

/*------------------------------------------------------
1. GUEST AUTH ROUTES (Only for non-logged-in users)
----------------------------------------------------------*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
});



/*------------------------------------------------------
2. EMAIL VERIFICATION PROCESS
----------------------------------------------------------*/
Route::get('/email/verify', [EmailVerificationController::class, 'emailVerifyForm'])->middleware('auth')->name('verification.notice');
Route::get('/custom/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware(['signed'])->name('custom.verification.verify');



/*------------------------------------------------------
3. EMAIL VERIFICATION PROCESS
----------------------------------------------------------*/
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
        Mail::to($request->user()->email)->send(new VerificationMail($request->user()));
        return response()->json([
            'status' => true,
            'message' => 'Verification link resent!',
        ]);
    })
        ->middleware(['throttle:6,1'])
        ->name('verification.send');
});






/*------------------------------------------------------
4. EMAIL VERIFICATION PROCESS
----------------------------------------------------------*/
Route::middleware(['auth', 'verified'])->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


