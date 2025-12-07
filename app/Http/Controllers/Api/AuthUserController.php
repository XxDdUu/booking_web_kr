<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AuthService;
class AuthUserController extends Controller
{
    protected $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }
       public function me(Request $request)
    {
        $header = $request->header('Authorization');
        $token = $this->service->extractToken($header);

        $user = $this->service->getUserFromToken($token);

        if (!$user) {
            return response()->json(['user' => null], 200);
        }

        $user->makeHidden(['password', 'remember_token']);

        return response()->json(['user' => $user]);
    }

    public function logout(Request $request)
    {
        $header = $request->header('Authorization');
        $token = $this->service->extractToken($header);

        if (!$token) {
            return response()->json(['message' => 'No token provided'], 400);
        }

        $user = $this->service->getUserFromToken($token);

        if (!$user) {
            return response()->json(['message' => 'Invalid token'], 400);
        }

        $this->service->logoutUser($user);

        return response()->json(['message' => 'Logged out successfully']);
    }
}
