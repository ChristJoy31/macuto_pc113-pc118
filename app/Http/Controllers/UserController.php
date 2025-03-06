<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function admin()
    {
        return User::all();
    }

    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('Mytoken')->plainTextToken;
            
            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 200);
        }
    
        return response()->json([
            'message' => 'Invalid credentials',
        ], 401); // Returns a proper HTTP 401 Unauthorized response
    }
}