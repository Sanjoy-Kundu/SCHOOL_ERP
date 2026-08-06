<?php

namespace App\Http\Controllers\Web\Academic;

use App\Http\Controllers\Controller;
use Exception;


class ShiftGroupController extends Controller
{
        /**
     * Show the Dashboard Academic Shift Group View.
     */
    public function academicShiftsGroups()
    {
        try{
          return view('pages.dashboard.academic.shiftGroupPage');
        }catch(Exception $ex){
            return response()->json(['status'=> 'error', 'message' => $ex->getMessage()]);
        }
    }
}
