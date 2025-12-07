<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Repositories\TokenRepository;

class TokenService
{
    protected TokenRepository $tokenRepo;

    public function __construct(TokenRepository $tokenRepository)
    {
        $this->tokenRepo = $tokenRepository;
    }

    // Tạo token nhớ lâu (lưu trong DB)
    public function createRememberToken($user): string
    {
        $plain = Str::random(60);
        $hashed = hash('sha256', $plain);

        $this->tokenRepo->saveRememberToken($user, $hashed);

        return $plain;
    }

    // Tạo token tạm (lưu Redis)
    public function createTemporaryToken($user): string
    {
        $token = Str::random(40);

        $this->tokenRepo->saveTemporaryToken($token,  $user->id);

        return $token;
    }

    // Extract từ header Authorization: Bearer xxx
    public function extractToken(?string $header): ?string
    {
        if (!$header) return null;
        return str_replace("Bearer ", "", $header);
    }

    // Lấy user từ bất kỳ token nào
    public function getUserFromToken(?string $token)
    {
        if (!$token) return null;

        // 1. Search in temporary tokens (Redis)
        $user = $this->tokenRepo->getUserByTempToken($token);
        if ($user) return $user;

        // 2. Search in remember tokens (DB)
        $hashed = hash('sha256', $token);
        return $this->tokenRepo->getUserByRememberToken($hashed);
    }
}
