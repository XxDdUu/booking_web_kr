<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Repositories\TokenRepository;
use Log;

class TokenService
{
    protected TokenRepository $tokenRepo;

    public function __construct(TokenRepository $tokenRepository)
    {
        $this->tokenRepo = $tokenRepository;
    }
    public function createRememberToken($user): string
    {
        $plain = Str::random(60);
        $hashed = hash('sha256', $plain);

        $this->tokenRepo->saveRememberToken($user, $hashed);

        return $plain;
    }
    public function createTemporaryToken($user): string
    {
        $token = Str::random(40);

        $this->tokenRepo->saveTemporaryToken($token,  $user->id);

        return $token;
    }
    public function extractToken(?string $header): ?string
    {
        if (!$header) return null;
        return str_replace("Bearer ", "", $header);
    }
    public function getUserFromToken(?string $token)
    {
        if (!$token) return null;

        $user = $this->tokenRepo->getUserByTempToken($token);
        if ($user) return $user;

        $hashed = hash('sha256', trim($token));

        return $this->tokenRepo->getUserByRememberToken($hashed);
    }
}
