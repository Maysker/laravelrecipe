<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Importing User model

class UserController extends Controller
{
    /**
     * Retrieving the list of all users.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Creating a new user.
     */
    public function store(Request $request)
    {
        // Validating input data
        $validatedData = $request->validate([
            'Username' => 'required|max:255',
            'Email' => 'required|email|unique:Users,Email',
            'Password' => 'required'
        ]);

        // Hashing the password
        $hashedPassword = bcrypt($validatedData['Password']);

        $userData = [
        'Username' => $validatedData['Username'],
        'Email' => $validatedData['Email'],
        'Password' => $hashedPassword,
        ];
        
        // Creating user and returning their data
        $user = User::create($userData);

        return response()->json($user, 201);
    }

    /**
     * Getting information about a specific user by ID.
     */
    public function show($id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    /**
     * Updating user data.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if ($user) {
            $user->update($request->all());
            return response()->json($user);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    /**
     * Deleting a user.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted']);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
}
