<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Exception;

class AuthController extends Controller
{
    /**
     * Handle API login requests supporting Email, Username, or Phone login with try-catch.
     */
    public function store(Request $request)
    {
        try {
            // Validate login request inputs
            $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

            $input = $request->username;
            $field = 'username';

            // Dynamically detect input type (Email, Phone, or Username)
            if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
                $field = 'email';
            } elseif (preg_match('/^[0-9]{11}$/', $input)) {
                $field = 'phone';
            }

            // Attempt login with stateful session and dynamic credentials
            if (Auth::attempt([$field => $input, 'password' => $request->password], $request->remember)) {
                
                $user = Auth::user();

                // Account status validation
                if (!$user->status) {
                    Auth::logout();
                    return response()->json([
                        'status' => false,
                        'message' => 'Your account is currently suspended. Please contact school administration.'
                    ], 403);
                }

                // Generate secure personal access token using Laravel Sanctum
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'status' => true,
                    'message' => 'Login successful.',
                    'token' => $token,
                    'user' => $user
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'The provided credentials do not match our school records.'
            ], 401);

        } catch (ValidationException $e) {
            // Rethrow validation exceptions so Laravel can auto-return the standard 422 JSON errors
            throw $e;
        } catch (Exception $e) {
            // Catch any other unexpected database or runtime errors safely
            return response()->json([
                'status' => false,
                'message' => 'An unexpected server error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Return currently authenticated user profile data with try-catch block.
     */
    public function details()
    {
        try {
            // Verify if there is an active authenticated user session
            if (!Auth::check()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized access.'
                ], 401);
            }

            return response()->json([
                'status' => true,
                'data' => Auth::user()->load('role') // Eloquent eager loading of user role relation
            ]);

        } catch (Exception $e) {
            // Catch unexpected runtime exceptions
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve profile data: ' . $e->getMessage()
            ], 500);
        }
    }
}