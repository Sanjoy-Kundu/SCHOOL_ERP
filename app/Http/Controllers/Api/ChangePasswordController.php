<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Throwable;

class ChangePasswordController extends Controller
{
    /**
     * Handle password update securely for dynamic roles.
     */
    public function changePassword(Request $request): JsonResponse
    {
        try {
            // 1. Perform backend input validation
            $validator = Validator::make($request->all(), [
                'current_password' => ['required', 'string'],
                'new_password' => [
                    'required', 
                    'string', 
                    'confirmed', 
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                ],
            ], [
                'current_password.required' => 'Current password is required to verify identity.',
                'new_password.required' => 'Please provide a new security password.',
                'new_password.confirmed' => 'New password confirmation does not match.',
                'new_password.min' => 'New password must be at least 8 characters with upper, lower, numbers, and symbols.',
            ]);

            // Return validation errors as JSON
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                    'message' => 'Please fix the validation errors.'
                ], 422);
            }

            $user = $request->user();

            // 2. Verify current password matches active session
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'The provided current password does not match our academic records.'
                ], 422);
            }

            // 3. Security Guard: Prevent using same current password as the new password
            if (Hash::check($request->new_password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'New password cannot be the same as your current password.'
                ], 422);
            }

            // 4. Safely perform hashed update
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Your portal security password has been changed successfully.'
            ]);

        } catch (Throwable $e) {
            // Log exception internally for debugging
            logger()->error('Change Password System Failure: ' . $e->getMessage(), [
                'user_id' => auth()->id() ?? 'unknown',
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'An unexpected server error occurred. Please try again later.'
            ], 500);
        }
    }
}