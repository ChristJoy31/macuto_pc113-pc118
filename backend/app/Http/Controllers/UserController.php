<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendUserSetPasswordMail;





class UserController extends Controller
{
// In your UserController or AuthController
public function profile(Request $request)
{
    $user = $request->user();

    return response()->json([
        'id' => $user->id,
        'name' => $user->first_name . ' ' . $user->last_name,
        'first_name' => $user->first_name,
        'middle_name' => $user->middle_name,
        'last_name' => $user->last_name,
        'suffix' => $user->suffix,
        'email' => $user->email,
        'contact_number' => $user->contact_number,
        'address' => $user->address,
        'gender' => $user->gender,
        'birthdate' => $user->birthdate?->format('Y-m-d'),
        'civil_status' => $user->civil_status,
        'citizenship' => $user->citizenship,
        'religion' => $user->religion,
        'position' => $user->position,
        'role' => $user->role,
        'photo' => $user->photo,
    ]);
}


    public function show(){
        return response()->json(User::all(),200);
    }

public function store(Request $request) 
{
    $request->validate([
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'role' => 'required|string',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    try {
        $photoPath = $request->hasFile('photo') 
            ? $request->file('photo')->store('user_photos', 'public') 
            : null;

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => null, // Set later by user
            'role' => $request->role,
            'photo' => $photoPath,
        ]);

        // Generate temporary token for password setup
        $token = $user->createToken('password-setup-token', ['set-password'])->plainTextToken;

        // Frontend URL for password setup page
        $frontendUrl = env('FRONTEND_URL', 'http://frontend.test');
        $setPasswordUrl = "{$frontendUrl}/setPassword.php?token={$token}&email={$user->email}";

        // Send email using your existing Mailable class
        Mail::to($user->email)->send(new SendUserSetPasswordMail($user, $setPasswordUrl));

        return response()->json([
            'message' => 'User created successfully. Email sent.',
            'success' => true,
        ], 200);

    } catch (\Exception $e) {
        \Log::error('User creation or email failed: ' . $e->getMessage());

        return response()->json([
            'message' => 'User creation or email sending failed.',
            'success' => false,
            'error' => $e->getMessage(),
        ], 500);
    }
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
        'password' => 'nullable|string|min:8',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Basic required fields
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->email = $request->email;
    $user->role = $request->role;


    // Optional fields (will update even if empty string is sent)
       if ($request->has('middle_name')) {
        $user->middle_name = $request->middle_name;
    }
    if ($request->has('contact_number')) {
        $user->contact_number = $request->contact_number;
    }

    if ($request->has('address')) {
        $user->address = $request->address;
    }

    if ($request->has('gender')) {
        $user->gender = $request->gender;
    }

    if ($request->has('birthdate')) {
        $user->birthdate = $request->birthdate;
    }

    if ($request->has('civil_status')) {
        $user->civil_status = $request->civil_status;
    }

    if ($request->has('citizenship')) {
        $user->citizenship = $request->citizenship;
    }

    if ($request->has('religion')) {
        $user->religion = $request->religion;
    }

    if ($request->has('position')) {
        $user->position = $request->position;
    }

    // Handle new image upload
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('user_photos', 'public');
        $user->photo = $photoPath;
    }

    $user->save();

    return response()->json([
        'message' => 'User updated successfully',
        'success' => true,
    ], 200);
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

public function setPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'token' => 'required',
        'password' => 'required|min:8|confirmed',
    ]);

    // Find the token record from Sanctum's personal_access_tokens table
    $accessToken = PersonalAccessToken::findToken($request->token);

    if (!$accessToken) {
        return response()->json(['message' => 'Invalid or expired token'], 400);
    }

    // Get the user from the token
    $user = $accessToken->tokenable;

    // Double check the email matches
    if ($user->email !== $request->email) {
        return response()->json(['message' => 'Email does not match token'], 400);
    }

    // Set the new password
    $user->password = Hash::make($request->password);
    $user->save();

    // Delete the token after password is set (optional for security)
    $accessToken->delete();

    return response()->json(['message' => 'Password set successfully']);
}


    public function getUserInfo(Request $request)
{
    $token = $request->bearerToken(); // plain token gikan sa frontend

    if (!$token) {
        return response()->json(['message' => 'Token missing'], 400);
    }

    // Use Laravel's built-in method to validate token
    $personalToken = PersonalAccessToken::findToken($token);

    if (!$personalToken) {
        return response()->json(['message' => 'Invalid token'], 401);
    }

    // Get the user from token
    $user = $personalToken->tokenable;

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    return response()->json([
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'email' => $user->email,
        'photo' => $user->photo,
    ]);
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

}  



