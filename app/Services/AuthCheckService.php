<?php

namespace App\Services;

use App\Models\User;

class AuthCheckService
{
    public function exists(string $field, string $value): bool
    {
        return User::where($field, $value)->exists();
    }
}
