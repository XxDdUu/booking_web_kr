<?php

namespace App\Repositories;

use App\Models\User;

class AuthRepository
{
    public function findUserByToken(string $hashedToken): ?User
    {
        return User::where('remember_token', $hashedToken)->first();
    }

    public function removeToken(User $user): void
    {
        $user->remember_token = null;
        $user->save();
    }
}
