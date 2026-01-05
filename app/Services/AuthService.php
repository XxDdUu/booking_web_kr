<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;
use App\Repositories\AuthRepository;
use App\Services\TokenService;
class AuthService
{
    protected $repo;
    protected TokenService $tokenService;

    public function __construct(AuthRepository $repo, TokenService $tokenService)
    {
        $this->repo = $repo;
        $this->tokenService = $tokenService;
    }
    public function loginUser($credentials, bool $keepLoggedIn = false)
    {
        $user = $this->repo->authenticate($credentials);
        if (!$user) return null;

        $token = null;

        if ($keepLoggedIn) {
            $token = $this->tokenService->createRememberToken($user);
            
            return [
                'success' => true,
                'user' => $user,
                'token' => $token,
                'type' => 'remember'
            ];  
        }
        $token = $this->tokenService->createTemporaryToken($user);

        return [
            'success' => true,
            'user' => $user,
            'message' => 'Login successful',
            'token' => $token
        ];
    }

    public function logoutUser($user): void
    {
        $this->repo->removeToken($user);
    }
}
