<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AuthService;
use App\Services\TokenService;
use Illuminate\Support\Facades\Log;
class AuthUserController extends Controller
{
    protected $service;

    protected TokenService $tokenService;


    public function __construct(AuthService $service, TokenService $tokenService)
    {
        $this->service = $service;
        $this->tokenService = $tokenService;
    }
       public function me(Request $request)
    {
        $header = $request->header('Authorization');
        $token = $this->tokenService->extractToken($header);

        $user = $this->tokenService->getUserFromToken($token);

        if (!$user) {
            return response()->json(['user' => null], 200);
        }

        $user->makeHidden(['password', 'remember_token']);

        return response()->json(['user' => $user]);
    }

    public function logout(Request $request)
    {
        $header = $request->header('Authorization');
        $token = $this->tokenService->extractToken($header);

        if (!$token) {
            return response()->json(['message' => 'No token provided'], 400);
        }

        $user = $this->tokenService->getUserFromToken($token);

        if (!$user) {
            return response()->json(['message' => 'Invalid token'], 400);
        }

        $this->service->logoutUser($user);

        return response()->json(['message' => 'Logged out successfully']);
    }
    public function login(Request $request)
    {
        $contact = $request->contact;
        if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
            $request->merge(['email' => $contact]);
        } else {
            $request->merge(['phone' => $contact]);
        }
        $request->request->remove('contact');

        $request->validate([
        'email' => ['nullable', 'email'],
        'phone' => ['nullable', 'string'],
        'password' => ['required', 'string', 'min:8'],
        'keepLoggedIn' => ['nullable', 'boolean'],
        ]);

        $data = $this->service->loginUser(
            credentials: $request->only(['email', 'phone', 'password']),
            keepLoggedIn: $request->boolean('keepLoggedIn', false)
        );
        return response()->json($data);
    }
        
}
