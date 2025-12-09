<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\TokenService;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $service;
    protected $tokenService;

    public function __construct(UserService $service, TokenService $tokenService)
    {
        $this->service = $service;
        $this->tokenService = $tokenService;
        
    }

    public function updateAvatarUrl(Request $request)
    {
        $data = $request->validate([
            'avatar_path' => 'required|string'
        ]);
        $token = $this->tokenService->extractToken($request->header('Authorization'));
        $user = $this->tokenService->getUserFromToken($token);
        
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        };

        $updated = $this->service->updateAvatarPath($user, $data['avatar_path']);

        return response()->json([
            'message' => 'Avatar updated successfully',
            'user' => $updated
        ]);
    }

}
