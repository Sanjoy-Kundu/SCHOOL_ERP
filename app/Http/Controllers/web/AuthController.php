<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
    /**
     * Show the custom responsive login view.
     */
    public function showLogin()
    {
        try{
          return view('auth.login');
        }catch(Exception $ex){
            return response()->json(['status'=> 'error', 'message' => $ex->getMessage()]);
        }
    }


    /**
     * Safely destroy session and logout the user from the web guard.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}
