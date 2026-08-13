<?php

use App\Http\Controllers\Web\Academic\AcademicController;
use App\Http\Controllers\Web\Academic\ClassSectionController;
use App\Http\Controllers\Web\Academic\ClassSetupController;
use App\Http\Controllers\Web\Academic\ReportPrintController;
use App\Http\Controllers\Web\Academic\ShiftGroupController;
use App\Http\Controllers\Web\Academic\SubjectAssignmentController;
use App\Http\Controllers\Web\Academic\SubjectPapersController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\ChangePasswordController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\EmailVerificationController;
use App\Http\Controllers\Web\Exam\ExamScheduleController;
use App\Http\Controllers\Web\Exam\ExamSetupController;
use App\Http\Controllers\web\Exam\ExamTypeController;
use App\Http\Controllers\Web\FeesManagement\FeeCategory\FeeCategoryController;
use App\Http\Controllers\Web\FessManagement\MonthMaster\MonthController;
use App\Http\Controllers\Web\ForgotPasswordController;
use App\Http\Controllers\Web\Settings\SchoolInformationController;
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
   Route::get('/change-password', [ChangePasswordController::class, 'index'])->name('change-password');

   /**
   * ----------------------------------------------------------
   * ACADEMIC PROCESSIONG
   * ----------------------------------------------------------
   */
  Route::get('/academic-session',[AcademicController::class, 'academicSession'])->name('academic-session');
  Route::get('/academic-classes-sections',[ClassSectionController::class, 'academicClassesSections'])->name('academic-classes-sections');
  Route::get('/academic-shifts-groups',[ShiftGroupController::class, 'academicShiftsGroups'])->name('academic-shifts-groups');
  Route::get('/academic-class-setups',[ClassSetupController::class, 'academicClassSetups'])->name('academic-class-setups');
  Route::get('/academic-subject-papers', [SubjectPapersController::class,'academicSubjectPaperSetup'])->name('academic-subject-papers');  
  Route::get('/academic-subject-assignments', [SubjectAssignmentController::class,'academicSubjectAssignmentSetup'])->name('academic-subject-assignments');  
  Route::get('/academic-subject-assignment-overviews', [SubjectAssignmentController::class,'academicSubjectAssignmentOverview'])->name('academic-subject-assignment-overviews');  
  Route::get('/academic-subject-assignments-overview/{classSetupId}/details', [SubjectAssignmentController::class,'academicSubjectAssignmentDetails'])->name('academic-subject-assignment-overviews-details');  








  /**
   * ----------------------------------------------------------------
   * PRINT AND REPORT PROCESSING 
   * ----------------------------------------------------------------
   */
  Route::get('/academic-subject-list-print', [ReportPrintController::class, 'subjectListPrint'])->name('academic-subject-list-print');
  Route::get('/academic-examination-shedule-lists-print', [ReportPrintController::class, 'examSheduleListPrint'])->name('academic-examination-shedule-lists-print');

  /**
   * ----------------------------------------------------------------
   * EXAM TYPE PROCESSING 
   * ----------------------------------------------------------------
   */
   Route::get('/exms/exam-types', [ExamTypeController::class, 'examTypePage'])->name('exms.exam-types.index');
   Route::get('/exms/exam-setups', [ExamSetupController::class, 'examSetupPage'])->name('exms.exam-setups.index');
   Route::get('/exms/exam-schedules', [ExamScheduleController::class, 'examSchedulePage'])->name('exms.exam-schedules.index');




  /**
     * ---------------------------------------------------------
     * MASTER SETTINGS MANAGEMENT PORTAL (Only GET View)
     * ---------------------------------------------------------
     */
    Route::get('/settings/school-information', [SchoolInformationController::class, 'schoolInformationCreate'])->name('settings.school-information.create');



    /*------------------------------------------------------
    FEE CATEGORY OPERATIONS
    ----------------------------------------------------------*/
    Route::get('/fees-categories', [FeeCategoryController::class, 'createFeesCategroy'])->name('fees-categories.create');
    Route::get('/fees-months', [MonthController::class, 'createMonth'])->name('fees-month.create');


});


