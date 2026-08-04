<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmailVerificationController extends Controller
{
    /**
     * EMAIL VARIFICATION FORM
     */
    public function emailVerifyForm(){
        try{
            return view('auth.verify-email');
        }catch(Exception $ex){
            return response()->json(['status' => 'error','message' => $ex->getMessage()]);
        }
    }




     /**
     * Custom email verification 
     */
    public function verify(Request $request)
    {
        
        if (! $request->hasValidSignature()) {
            abort(401, 'This verification link is invalid or expired.');
        }

        
        $user = User::findOrFail($request->route('id'));

       
        if ($user->email_verified_at !== null) {
            return redirect('/login')->with('success', 'Email already verified. Please log in.');
        }

       
        $user->email_verified_at = Carbon::now();
        $user->save(); 

        return redirect('/login')->with('success', 'Your email has been verified successfully! You can now log in.');
    }






}
