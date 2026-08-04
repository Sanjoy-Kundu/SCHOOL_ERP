<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    //Forget Password Blade file
        public function showLinkRequestForm(){
        try{
            return view('auth.forgot-password');
        }catch(Exception $ex){
            return response()->json(['status' => 'error','message' => $ex->getMessage()]);
        }
    }
    //Reset Password Blade file
      public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email') 
        ]);
    }
}
