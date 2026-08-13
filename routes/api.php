<?php

use App\Http\Controllers\Api\Academic\AcademicSessionController;
use App\Http\Controllers\Api\Academic\ClassSetupController;
use App\Http\Controllers\Api\Academic\GroupController;
use App\Http\Controllers\Api\Academic\PaperController;
use App\Http\Controllers\Api\Academic\SchoolClassController;
use App\Http\Controllers\Api\Academic\SectionController;
use App\Http\Controllers\Api\Academic\ShiftController;
use App\Http\Controllers\Api\Academic\SubjectAssignmentController;
use App\Http\Controllers\Api\Academic\SubjectController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChangePasswordController;
use App\Http\Controllers\Api\Exam\ExamScheduleController;
use App\Http\Controllers\Api\Exam\ExamSetupController;
use App\Http\Controllers\Api\Exam\ExamTypeController;
use App\Http\Controllers\Api\FeesManagement\FeeCategory\FeeCategoryController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\Settings\SchoolInformationController;
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




    /*--------------------------------------------------
    School Class Setup Management
    ->middleware('permission:class_setups.view') ->middleware('permission:class_setups.create') ->middleware('permission:class_setups.view') ->middleware('permission:class_setups.edit') ->middleware('permission:class_setups.delete')
    ---------------------------------------------------*/
    Route::controller(ClassSetupController::class)->group(function () {
        Route::get('/class-setup-lists', 'index')->name('api.class_setups.index');
        Route::post('/class-setup-store', 'store')->name('api.class_setups.store');
        Route::get('/class-setup-details/{id}', 'show')->name('api.class_setups.show');
        Route::post('/class-setup-update/{id}', 'update')->name('api.class_setups.update');
        Route::delete('/class-setup-delte/{id}', 'destroy')->name('api.class_setups.destroy');
    });



    /*--------------------------------------------------
    Subject Master Management 
    ->middleware('permission:subjects_papers.view') ->middleware('permission:subjects_papers.create') ->middleware('permission:subjects_papers.view') ->middleware('permission:subjects_papers.edit')  ->middleware('permission:subjects_papers.delete')
    ---------------------------------------------------*/
    Route::controller(SubjectController::class)->group(function () {
        Route::get('/subject-lists', 'index')->name('api.subjects.index');
        Route::post('/subject-store', 'store')->name('api.subjects.store');
        Route::get('/subject-details/{id}', 'show')->name('api.subjects.show');
        Route::post('/subject-update/{id}', 'update')->name('api.subjects.update');
        Route::delete('/subject-delte/{id}', 'destroy')->name('api.subjects.destroy');
    });


     /*--------------------------------------------------
    Paper Master Management 
    ->middleware('permission:subjects_papers.view') ->middleware('permission:subjects_papers.create') ->middleware('permission:subjects_papers.view') ->middleware('permission:subjects_papers.edit') ->middleware('permission:subjects_papers.delete')
    ---------------------------------------------------*/
    Route::controller(PaperController::class)->group(function () {
        Route::get('/paper-lists', 'index')->name('api.papers.index');
        Route::post('/paper-store', 'store')->name('api.papers.store');
        Route::get('/paper-details/{id}', 'show')->name('api.papers.show');
        Route::post('/paper-update/{id}', 'update')->name('api.papers.update');
        Route::delete('/paper-delte/{id}', 'destroy')->name('api.papers.destroy');
    });




    /*--------------------------------------------------
    School Subject Assignment Management 
    ->middleware('permission:subject_assignments.view')  ->middleware('permission:subject_assignments.create')  ->middleware('permission:subject_assignments.view')  ->middleware('permission:subject_assignments.edit')   ->middleware('permission:subject_assignments.delete') ->middleware('permission:subject_assignments.view')  ->middleware('permission:subject_assignments.view') ->middleware('permission:subject_assignments.edit')
    ---------------------------------------------------*/
    Route::controller(SubjectAssignmentController::class)->group(function () {
        Route::get('/subject-assignment-lists', 'index')->name('api.subject_assignments.index');
        Route::post('/subject-assignment-store', 'store')->name('api.subject_assignments.store');
        Route::get('/subject-assignment-details/{id}', 'show')->name('api.subject_assignments.show');
        Route::post('/subject-assignment-update/{id}', 'update')->name('api.subject_assignments.update');
        Route::delete('/subject-assignment-delte/{id}', 'destroy')->name('api.subject_assignments.destroy');
        Route::get('/subject-assignment-overviews', 'getOverviews')->name('api.subject_assignments.overviews');
        Route::get('/subject-assignment-overviews/{classSetupId}', 'getDetails')->name('api.subject_assignments.details');
         Route::patch('/subject-assignment-sort-order/{id}', 'updateSortOrder')->name('api.subject_assignments.sort_order');
    });





    /*--------------------------------------------------
      Master School Information API Gateway
    ---------------------------------------------------*/
    Route::controller(SchoolInformationController::class)->group(function () {
        Route::get('/school-information-details', 'show')->name('api.school-information.show');
        Route::post('/school-information-update', 'update')->name('api.school-information.update');
    });



    /*--------------------------------------------------
      Exam Type 
    ---------------------------------------------------*/
     Route::controller(ExamTypeController::class)->group(function () {
        Route::get('/exam-type-lists', 'index')->name('api.exam-types.index');
        Route::post('/exam-type-store', 'store')->name('api.exam-types.store');
        Route::get('/exam-type-details/{id}', 'show')->name('api.exam-types.show');
        Route::post('/exam-type-update/{id}', 'update')->name('api.exam-types.update');
        Route::delete('/exam-type-delete/{id}', 'destroy')->name('api.exam-types.destroy');
    });


    /*--------------------------------------------------
      Exam Setup 
    ---------------------------------------------------*/
     Route::controller(ExamSetupController::class)->group(function () {
        Route::get('/exam-setup-lists', 'index')->name('api.exam-setups.index');
        Route::post('/exam-setup-store', 'store')->name('api.exam-setups.store');
        Route::get('/exam-setup-details/{id}', 'show')->name('api.exam-setups.show');
        Route::post('/exam-setup-update/{id}', 'update')->name('api.exam-setups.update');
        Route::delete('/exam-setup-delete/{id}', 'destroy')->name('api.exam-setups.destroy');
        Route::get('/exam-setup-dependencies', 'getFormDependencies')->name('api.exam-setups.dependencies');
    });


     /*--------------------------------------------------
      Exam Schedule API Routes - FIXED: Fully Mapped 
    ---------------------------------------------------*/
    Route::controller(ExamScheduleController::class)->group(function () {
        Route::get('/exam-schedule-lists', 'index')->name('api.exam-schedules.index');
        Route::post('/exam-schedule-store', 'store')->name('api.exam-schedules.store');
        Route::get('/exam-schedule-details/{id}', 'show')->name('api.exam-schedules.show');
        Route::post('/exam-schedule-update/{id}', 'update')->name('api.exam-schedules.update');
        Route::delete('/exam-schedule-delete/{id}', 'destroy')->name('api.exam-schedules.destroy');

        Route::get('/exam-schedule-dependencies', 'getFormDependencies')->name('api.exam-schedules.dependencies');
        Route::get('/academic/exam-schedules/class-setups/{classId}', 'getClassSetups')->name('api.exam-schedules.class-setups');
        Route::get('/academic/exam-schedules/subject-assignments/{classSetupId}', 'getSubjectAssignments')->name('api.exam-schedules.subject-assignments');
    });



    /*--------------------------------------------------
      Fee Category Management API Endpoints
    ---------------------------------------------------*/
    Route::controller(FeeCategoryController::class)->group(function () {
        Route::get('/fees/categories/lists', 'index')->name('api.fees.categories.index'); 
        Route::post('/fees/categories/store', 'store')->name('api.fees.categories.store');
        Route::get('/fees/categories/details/{id}', 'show')->name('api.fees.categories.show');
        Route::post('/fees/categories/update/{id}', 'update')->name('api.fees.categories.update');
        Route::delete('/fees/categories/delete/{id}', 'destroy')->name('api.fees.categories.destroy');
        Route::patch('/fees/categories/{id}/toggle-status', 'toggleStatus')->name('api.fees.categories.toggle-status');
    });
});

