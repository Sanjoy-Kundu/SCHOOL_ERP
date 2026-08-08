<?php

namespace App\Http\Controllers\Web\Academic;

use App\Http\Controllers\Controller;
use Exception;


class SubjectAssignmentController extends Controller
{
 /**
     * Show the Dashboard Academic Subject Assignment View.
     */
    public function academicSubjectAssignmentSetup()
    {
        try{
          return view('pages.dashboard.academic.subjectAssignmentPage');
        }catch(Exception $ex){
            return response()->json(['status'=> 'error', 'message' => $ex->getMessage()]);
        }
    }


 /**
     * Show the Dashboard Academic Subject Assignment View.
     */
    public function academicSubjectAssignmentOverview()
    {
        try{
          return view('pages.dashboard.academic.subjectAssignmentOverviewPage');
        }catch(Exception $ex){
            return response()->json(['status'=> 'error', 'message' => $ex->getMessage()]);
        }
    }
 /**
     * Show the Dashboard Academic Subject Assignment View.
     */
    public function academicSubjectAssignmentDetails()
    {
        try{
          return view('pages.dashboard.academic.subjectAssignmentOverviewDetailsPage');
        }catch(Exception $ex){
            return response()->json(['status'=> 'error', 'message' => $ex->getMessage()]);
        }
    }
}
