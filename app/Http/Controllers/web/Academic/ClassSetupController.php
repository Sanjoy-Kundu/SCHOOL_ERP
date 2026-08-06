<?php

namespace App\Http\Controllers\Web\Academic;

use App\Http\Controllers\Controller;
use Exception;


class ClassSetupController extends Controller
{
    /**
     * Show the Dashboard Academic Class Setup View.
     */
    public function academicClassSetups()
    {
        try{
          return view('pages.dashboard.academic.classSetupsPage');
        }catch(Exception $ex){
            return response()->json(['status'=> 'error', 'message' => $ex->getMessage()]);
        }
    }
}
