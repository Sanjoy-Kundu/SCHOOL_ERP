<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
     /**
     * Safely destroy session and logout the user from the web guard.
     */
    public function logout(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Delete all personal access tokens from the database for safety (Sanctum)
            if ($user) {
                $user->tokens()->delete();
            }

            // Logout from stateful web session guard
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login');
            
        } catch (Exception $ex) {
            // Fallback to safety in case of any database or unexpected exception
            return redirect('/login');
        }
    }
}
