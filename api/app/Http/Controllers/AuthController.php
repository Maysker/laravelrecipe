<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Method for user registration
    public function register(Request $request)
{
    \Log::info('Register method called.');

    try {
        // Your data validation...
        $validatedData = $request->validate([
            'Username' => 'required|string|max:255',
            'Email' => 'required|string|email|max:255|unique:Users',
            'Password' => 'required|string|min:8|confirmed',
        ]);

        \Log::info('Data validated successfully.');

        // Creating user...
        $user = User::create([
            'Username' => $validatedData['Username'],
            'Email' => $validatedData['Email'],
            'Password' => Hash::make($validatedData['Password']),
            // Other fields...
        ]);

        \Log::info('User created successfully.', ['user_id' => $user->id]);

        // Creating token for the user...
        $token = $user->createToken('auth_token')->plainTextToken;

        // Response to the client...
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);

    } catch (\Exception $e) {
        \Log::error('Error in register method.', ['message' => $e->getMessage(), 'stack' => $e->getTraceAsString()]);
        // Returning error response to the client
        return response()->json(['message' => 'Registration failed.'], 500);
    }
}



    // Method for user login
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = User::where('Email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    // Method for user logout
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }

    // Method for getting user data
    public function me()
    {
        return auth()->user();
    }
}
