<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                // Create token for the user
                try {
                    $token = $user->createToken('Mytoken')->plainTextToken;
                } catch (\Exception $e) {  
                    Log::error("Error creating token: " . $e->getMessage());
                    return response()->json([
                        'message' => 'Failed to generate authentication token.'
                    ], 500);
                }

                return response()->json([
                    'user' => $user,
                    'token' => $token,
                ], 200);
            }

            return response()->json(['message' => 'Invalid credentials'], 401);

        } catch (\Exception $e) {
            Log::error("Login error: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred during login.'], 500);
        }
    }
}

