<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Exception;

class ChangePasswordController extends Controller
{
  /**
     * Show the Password Change View.
     */
    public function index()
    {
        try{
          return view('pages.changePasswordPage');
        }catch(Exception $ex){
            return response()->json(['status'=> 'error', 'message' => $ex->getMessage()]);
        }
    }
}
