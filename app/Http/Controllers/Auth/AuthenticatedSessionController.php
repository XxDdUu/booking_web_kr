<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Route

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $credentials = $request->only(['email', 'phone', 'password']);

        $field = isset($credentials['email']) ? 'email' : 'phone';

        if (!Auth::attempt([$field => $credentials[$field]
        , 'password' => $credentials['password']]
        , $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'message' => ['The provided credentials do not match our records.'],
            ]);
        }
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'The provided credentials do not match our records.',
            'token' => $token,
            'user' => $user,
        ], 422);
    }
    public function destroy(Request $request): RedirectResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
