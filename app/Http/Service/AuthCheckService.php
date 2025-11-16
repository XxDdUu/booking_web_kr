<?php

namespace App\Services;

use App\Models\User;

class AuthCheckService
{
    public function emailExists(string $email): bool
    {
        return User::where('email', $email)->exists();
    }

    public function phoneExists(string $phone): bool
    {
        return User::where('phone', $phone)->exists();
    }
}
