<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Redis;

class TokenRepository
{
    // Lưu token nhớ lâu (DB)
    public function saveRememberToken(User $user, string $hashedToken): void
    {
        $user->remember_token = $hashedToken;
        $user->save();
    }

    // Lưu token tạm trong Redis 2h
    public function saveTemporaryToken(string $token, string $userId): void
    {
        Redis::setex("temp_token:$token", 7200, $userId);
    }

    // Lấy user từ remember_token (DB)
    public function getUserByRememberToken(string $hashedToken): ?User
    {
        return User::where('remember_token', $hashedToken)->first();
    }

    // Lấy user từ temporary token (Redis)
    public function getUserByTempToken(string $token): ?User
    {
        $userId = Redis::get("temp_token:$token");

        if (!$userId) return null;

        return User::find($userId);
    }
}
