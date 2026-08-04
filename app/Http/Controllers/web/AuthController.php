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


    // LOGOUT PROCESS
    public function logout(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user) {
                $user->tokens()->delete();
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login');
        } catch(Exception $ex) {
            // Fallback to safety in case of any database exception
            return redirect('/login');
        }
    }
}
