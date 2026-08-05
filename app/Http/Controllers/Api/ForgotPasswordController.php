<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;
use Exception;

class ForgotPasswordController extends Controller
{
    // Reset Password Linkp
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users,email',
            ],
            [
                'email.exists' => "We can't find a user with that email address.",
            ],
        );

        try {
            $token = Str::random(60);

            $user = User::where('email', $request->email)->first();

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'email' => $request->email,
                    'token' => Hash::make($token),
                    'created_at' => now(),
                ],
            );

            Mail::to($request->email)->send(new ResetPasswordMail($user, $token));

            return response()->json(
                [
                    'status' => true,
                    'message' => 'A password reset link has been sent to your email address!',
                ],
                200,
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Failed to send password reset mail. Server error.',
                ],
                500,
            );
        }
    }

    /**
     * Handle secure password reset update.
     */
    public function resetPassword(Request $request): JsonResponse
    {
        try {
            // 1. Perform backend input validation
            $validator = Validator::make(
                $request->all(),
                [
                    'token' => ['required'],
                    'email' => ['required', 'email', 'exists:users,email'],
                    'password' => [
                        'required',
                        'string',
                        'confirmed', // Must match with password_confirmation field
                        Password::min(8)->letters()->mixedCase()->numbers()->symbols(),
                    ],
                ],
                [
                    'token.required' => 'The password reset token is required.',
                    'email.required' => 'Email address is required to perform reset.',
                    'email.exists' => 'No user was found associated with this email address.',
                    'password.required' => 'Please provide a new secure password.',
                    'password.confirmed' => 'Confirm password does not match.',
                    'password.min' => 'New password must be at least 8 characters with upper, lower, numbers, and symbols.',
                ],
            );

            // Return inline validation errors
            if ($validator->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'errors' => $validator->errors(),
                        'message' => 'Please fix the validation errors.',
                    ],
                    422,
                );
            }

            // 2. Fetch the corresponding password reset token record
            $passwordReset = DB::table('password_reset_tokens')->where('email', $request->email)->first();

            // 3. Verify token exists and checks against cryptographically secure hash
            if (!$passwordReset || Hash::check($request->token, $passwordReset->token) === false) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'This password reset token is invalid or has already been used.',
                    ],
                    422,
                );
            }

            // 4. Validate if token age exceeds safety limits (Default: 60 minutes)
            if (now()->subMinutes(60)->gt($passwordReset->created_at)) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'This password reset token has expired. Please request a new link.',
                    ],
                    422,
                );
            }

            // 5. Update user password securely
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $user->password = Hash::make($request->password);
                $user->save();

                // Destroy sessional token upon successful recovery
                DB::table('password_reset_tokens')->where('email', $request->email)->delete();

                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Your password has been successfully reset! You can now log in.',
                    ],
                    200,
                );
            }

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Unable to locate user associated with this recovery process.',
                ],
                404,
            );
        } catch (Throwable $e) {
            // Log critical system error securely
            logger()->error('Critical Reset Password Exception: ' . $e->getMessage(), [
                'email' => $request->email ?? 'unknown',
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Something went wrong while resetting the password. Please try again later.',
                ],
                500,
            );
        }
    }
}
