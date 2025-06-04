<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    // Register a new user (default role: user)
    public function register(Request $request) {
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'in:user,admin' // Optional: allow admin to set role
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'user'
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'role' => $user->role
        ], 201);
    }

    // Login user and return token and role
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => $user,
                'role' => $user->role
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Example: Get current user info (for frontend role check)
    public function me(Request $request) {
        $user = $request->user();
        if ($user) {
            return response()->json([
                'user' => $user,
                'role' => $user->role
            ]);
        }
        // Guest (readonly)
        return response()->json([
            'user' => null,
            'role' => 'guest'
        ]);
    }
}