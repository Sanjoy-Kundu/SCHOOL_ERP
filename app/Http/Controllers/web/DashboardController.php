<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Exception;

class DashboardController extends Controller
{
    /**
     * Show the Dashboard View.
     */
    public function index()
    {
        try{
          return view('pages.dashboardPage');
        }catch(Exception $ex){
            return response()->json(['status'=> 'error', 'message' => $ex->getMessage()]);
        }
    }
}
