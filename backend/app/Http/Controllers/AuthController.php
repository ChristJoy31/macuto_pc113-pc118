<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\PasswordReset;
use App\Mail\ResetPasswordMail;
use Carbon\Carbon;

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

    public function sendResetLink(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email'
    ]);

    $token = Str::random(64);

    PasswordReset::updateOrCreate(
        ['email' => $request->email],
        ['token' => $token, 'created_at' => now()]
    );

 $frontendUrl = env('FRONTEND_URL', 'http://frontend.test');
$resetLink = "{$frontendUrl}/resetPassword.php?token={$token}&email={$request->email}";


    Mail::to($request->email)->send(new ResetPasswordMail($resetLink));

    return response()->json([
         'status' => 'success',
    'message' => 'Password reset link sent.',
        ],200);
}

public function resetPassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'password' => 'required|min:8|confirmed',
    ]);

    // Pangita ang reset record base sa token
    $reset = PasswordReset::where('token', $request->token)->first();

    if (!$reset || Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
        return response()->json(['message' => 'Invalid or expired token.'], 400);
    }

    $user = User::where('email', $reset->email)->first();

    if (!$user) {
        return response()->json(['message' => 'User not found.'], 404);
    }

    // Reset the password
    $user->password = Hash::make($request->password);
    $user->save();

    // Delete the reset record after success
    $reset->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'Password reset successful!',

     ],200);
}


    
}

