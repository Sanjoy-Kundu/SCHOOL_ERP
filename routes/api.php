<?php

use App\Http\Controllers\Api\Academic\AcademicSessionController;
use App\Http\Controllers\Api\Academic\GroupController;
use App\Http\Controllers\Api\Academic\SchoolClassController;
use App\Http\Controllers\Api\Academic\SectionController;
use App\Http\Controllers\Api\Academic\ShiftController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChangePasswordController;
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
    Route::post('/auth/change-password', [ChangePasswordController::class, 'changePassword'])->name('api.auth.change-password');



    /*-------------------------------
    Academic Session Management ->middleware('permission:academic_sessions.view') ->middleware('permission:academic_sessions.create') ->middleware('permission:academic_sessions.view') ->middleware('permission:academic_sessions.edit') ->middleware('permission:academic_sessions.delete') ->middleware('permission:academic_sessions.edit')
    --------------------------------*/
    Route::controller(AcademicSessionController::class)->group(function () {
        Route::get('/academic-session-lists', 'index')->name('api.academic_sessions.index');
        Route::post('/academic-session-store', 'store')->name('api.academic_sessions.store');
        Route::get('/academic-session-details/{id}', 'show')->name('api.academic_sessions.show');
        Route::post('/academic-session-update/{id}', 'update')->name('api.academic_sessions.update');
        Route::delete('/academic-session-delte/{id}', 'destroy')->name('api.academic_sessions.destroy');
        Route::patch('/academic-session-set-active/{id}', 'setActive')->name('api.academic_sessions.set_active');
    });



    /*--------------------------------------------------
      School Classes Management
      ->middleware('permission:classes_sections.view') ->middleware('permission:classes_sections.create') ->middleware('permission:classes_sections.view') ->middleware('permission:classes_sections.edit') ->middleware('permission:classes_sections.delete')
    ---------------------------------------------------*/
    Route::controller(SchoolClassController::class)->group(function () {
        Route::get('/school-class-lists', 'index')->name('api.school_classes.index');
        Route::post('/school-class-store', 'store')->name('api.school_classes.store');
        Route::get('/school-class-details/{id}', 'show')->name('api.school_classes.show');
        Route::post('/school-class-update/{id}', 'update')->name('api.school_classes.update');
        Route::delete('/school-class-delte/{id}', 'destroy')->name('api.school_classes.destroy');
    });



     /*-------------------------------
       Optional Sections Management 
       ->middleware('permission:classes_sections.view') ->middleware('permission:classes_sections.create') ->middleware('permission:classes_sections.view') ->middleware('permission:classes_sections.edit') ->middleware('permission:classes_sections.delete')
    --------------------------------*/
    Route::controller(SectionController::class)->group(function () {
        Route::get('/section-lists', 'index')->name('api.sections.index');
        Route::post('/section-store', 'store')->name('api.sections.store');
        Route::get('/section-details/{id}', 'show')->name('api.sections.show');
        Route::post('/section-update/{id}', 'update')->name('api.sections.update');
        Route::delete('/section-delte/{id}', 'destroy')->name('api.sections.destroy');
    });




    /*--------------------------------------------------
    Optional School Shifts Management 
    ->middleware('permission:shifts_groups.view') ->middleware('permission:shifts_groups.create') ->middleware('permission:shifts_groups.view') ->middleware('permission:shifts_groups.edit') ->middleware('permission:shifts_groups.delete')
    ---------------------------------------------------*/
    Route::controller(ShiftController::class)->group(function () {
        Route::get('/shift-lists', 'index')->name('api.shifts.index');
        Route::post('/shift-store', 'store')->name('api.shifts.store');
        Route::get('/shift-details/{id}', 'show')->name('api.shifts.show');
        Route::post('/shift-update/{id}', 'update')->name('api.shifts.update');
        Route::delete('/shift-delte/{id}', 'destroy')->name('api.shifts.destroy');
    });



     /*--------------------------------------------------
       School Groups Management 
       ->middleware('permission:shifts_groups.view') ->middleware('permission:shifts_groups.create') ->middleware('permission:shifts_groups.view') ->middleware('permission:shifts_groups.edit')  ->middleware('permission:shifts_groups.delete')
    ---------------------------------------------------*/
    Route::controller(GroupController::class)->group(function () {
        Route::get('/group-lists', 'index')->name('api.groups.index');
        Route::post('/group-store', 'store')->name('api.groups.store');
        Route::get('/group-details/{id}', 'show')->name('api.groups.show');
        Route::post('/group-update/{id}', 'update')->name('api.groups.update');
        Route::delete('/group-delte/{id}', 'destroy')->name('api.groups.destroy');
    });
});

