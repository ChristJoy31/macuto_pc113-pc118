<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function show(){
        return response()->json(User::all(),200);
    }

    public function store(Request $request)
{
    $request->validate([
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8', 
        'role' => 'required|string',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('user_photos', 'public');
    } else {
        $photoPath = null;
    }
    

    $user = User::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $request->role,
        'photo' => $photoPath,
    ]);

    return response()->json([
        'message' => 'User Created successfully',
        'success' => true,
    ], 200);
}

    public function search(Request $request)
{
    $search = $request->query('find');

    if ($search) {
        $users = User::where('id', $search)
            ->orWhere('first_name', 'like', "%{$search}%")
            ->orWhere('last_name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->get();

        if ($users->isNotEmpty()) {
            return response()->json($users);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    $users = User::all();
    return response()->json($users);
}

/**
 * Update the specified resource in storage.
 */
    public function update(Request $request, $id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $request->validate([
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|string',
    ]);

    $user->update($request->all());

    return response()->json([
        'message' => 'User updated successfully',
        // 'user' => $user,
        'success' => true,
    ],200);
}

/**
 * Remove the specified resource from storage.
 */
    public function destroy($id)
{
    $user = User::find($id);
    if (is_null($user)) {
        return response()->json(['message' => 'User not found'], 404);
    }
    $user->delete();
    return response()->json([
        'message' => 'User deleted successfully',
        'success' => true,
    ], 200);
}


    public function admin()
    {
        try {
            $users = User::all();
            return response()->json($users, 200);
        } catch (\Exception $e) {
            Log::error("Error fetching users: " . $e->getMessage());
            return response()->json([
                'message' => 'Something went wrong while fetching users.'
            ], 500);
        }
    }

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



