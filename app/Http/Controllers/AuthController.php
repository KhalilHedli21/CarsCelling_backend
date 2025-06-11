<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    /**
     * Register a new user (default role: user).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|unique:users|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:6|confirmed',
            // 'role' => 'sometimes|in:user' 
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user'
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => [
                'user' => $user->only(['id', 'name', 'email', 'role']),
                'token' => $token,
                'role' => $user->role
            ],
            'message' => 'User registered successfully'
        ], 201);
    }

    /**
     * Login user and return token and role.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            Log::warning('Failed login attempt', ['email' => $data['email']]);
            return response()->json([
                'error' => 'Invalid credentials'
            ], 401);
        }

        // Revoke existing tokens for security (optional: single-session policy)
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        Log::info('User logged in', ['user_id' => $user->id, 'email' => $user->email]);

        return response()->json([
            'data' => [
                'user' => $user->only(['id', 'name', 'email', 'role']),
                'token' => $token,
                'role' => $user->role
            ],
            'message' => 'Login successful'
        ], 200);
    }

    /**
     * Get current user info (for frontend role check).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user) {
            return response()->json([
                'data' => [
                    'user' => $user->only(['id', 'username', 'email', 'role']),
                    'role' => $user->role
                ],
                'message' => 'User information retrieved'
            ], 200);
        }

        return response()->json([
            'data' => [
                'user' => null,
                'role' => 'guest'
            ],
            'message' => 'Guest access'
        ], 200);
    }

    /**
     * Update user profile.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'username' => 'sometimes|required|string|unique:users,username,' . $user->id . '|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id . '|max:255',
            'password' => 'sometimes|required|string|min:6|confirmed',
            'current_password' => 'required_with:password|nullable|string'
        ]);

        // Verify current password if updating password
        if ($request->has('password') && !Hash::check($data['current_password'], $user->password)) {
            return response()->json([
                'error' => 'Current password is incorrect'
            ], 403);
        }

        if ($request->has('username')) {
            $user->username = $data['username'];
        }

        if ($request->has('email')) {
            $user->email = $data['email'];
        }

        if ($request->has('password')) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        Log::info('User profile updated', ['user_id' => $user->id, 'email' => $user->email]);

        return response()->json([
            'data' => [
                'user' => $user->only(['id', 'username', 'email', 'role'])
            ],
            'message' => 'Profile updated successfully'
        ], 200);
    }

    /**
     * Logout user and revoke token.
     *
     * @param Request $request
     * @return JsonResponse
    */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user) {
            // Revoke all tokens for the user
            $user->tokens()->delete();

            return response()->json([
                'message' => 'Logged out successfully'
            ], 200);
        }

        return response()->json([
            'error' => 'Unauthorized'
        ], 401);
    }

}