<?php

namespace App\Http\Controllers\Web\Academic;

use App\Http\Controllers\Controller;
use Exception;


class SubjectPapersController extends Controller
{
 /**
     * Show the Dashboard Academic Subject & Paper  View.
     */
    public function academicSubjectPaperSetup()
    {
        try{
          return view('pages.dashboard.academic.subjectPapersPage');
        }catch(Exception $ex){
            return response()->json(['status'=> 'error', 'message' => $ex->getMessage()]);
        }
    }
}
