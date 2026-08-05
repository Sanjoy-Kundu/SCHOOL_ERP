<?php

namespace App\Http\Controllers\Web\Academic;

use App\Http\Controllers\Controller;
use Exception;


class AcademicController extends Controller
{
    /**
     * Show the Dashboard View.
     */
    public function academicSession()
    {
        try{
          return view('pages.dashboard.academic.academicSessionPage');
        }catch(Exception $ex){
            return response()->json(['status'=> 'error', 'message' => $ex->getMessage()]);
        }
    }
}
