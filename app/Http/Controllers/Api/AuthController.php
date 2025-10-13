<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Login user and issue Sanctum token
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        // Revoke previous tokens (optional for mobile)
        $user->tokens()->delete();

        // Create new token
        $token = $user->createToken('mobile-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => $user,
        ]);
    }

    /**
     * Get current authenticated user
     */
    public function me(Request $request)
    {
        return response()->json([
            'status' => true,
            'user' => $request->user(),
        ]);
    }

    /**
     * Logout and revoke tokens
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out',
        ]);
    }

    /**
     * Refresh token manually (optional — not required in Sanctum)
     */
    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        $newToken = $user->createToken('mobile-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'access_token' => $newToken,
            'token_type' => 'bearer',
        ]);
    }
}
