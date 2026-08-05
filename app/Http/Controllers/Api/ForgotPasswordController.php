<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    // Reset Password Linkp
   public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => "We can't find a user with that email address."
        ]);

        try {
            $token = Str::random(60);

            
            $user = User::where('email', $request->email)->first();

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'email' => $request->email,
                    'token' => Hash::make($token),
                    'created_at' => now()
                ]
            );

            
            Mail::to($request->email)->send(new ResetPasswordMail($user, $token));

            return response()->json([
                'status' => true,
                'message' => 'A password reset link has been sent to your email address!'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to send password reset mail. Server error.'
            ], 500);
        }
    }

    /**
     * ২. New Password Update
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $passwordReset = DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->first();

            if (!$passwordReset || Hash::check($request->token, $passwordReset->token) === false) {
                return response()->json([
                    'status' => false,
                    'message' => 'This password reset token is invalid.'
                ], 422);
            }

            if (now()->subMinutes(60)->gt($passwordReset->created_at)) {
                return response()->json([
                    'status' => false,
                    'message' => 'This password reset token has expired.'
                ], 422);
            }

            $user = User::where('email', $request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Your password has been successfully reset! You can now log in.'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong while resetting the password.'
            ], 500);
        }
    }
}
