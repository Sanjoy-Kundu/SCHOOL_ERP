<?php

namespace App\Http\Controllers\Web\Academic;

use App\Http\Controllers\Controller;
use Exception;

class ClassSectionController extends Controller
{
        /**
     * Show the Dashboard Academic Class Section View.
     */
    public function academicClassesSections()
    {
        try{
          return view('pages.dashboard.academic.classesSectionPage');
        }catch(Exception $ex){
            return response()->json(['status'=> 'error', 'message' => $ex->getMessage()]);
        }
    }
}
