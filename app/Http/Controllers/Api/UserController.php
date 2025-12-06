<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function updateAvatarUrl(Request $request)
    {
        $data = $request->validate([
            'avatar_path' => 'required|string'
        ]);
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        };

        $updated = $this->service->updateAvatarPath($user, $data['avatar_path']);

        return response()->json([
            'message' => 'Avatar updated successfully',
            'user' => $updated
        ]);
    }
    private function getUserFromToken(Request $request)
    {
        $auth = $request->header('Authorization');

        if (!$auth) return null;

        $token = str_replace('Bearer ', '', $auth);
        $hashed = hash('sha256', $token);

        return User::where('remember_token', $hashed)->first();
    }

}
