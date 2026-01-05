<?php

namespace App\Repositories;
use Illuminate\Support\Str;
use App\Models\User;

class AuthRepository
{   
    public function authenticate(array $credentials): ?USer
    {
        $user = User::where(function ($query) use ($credentials) {
            if (isset($credentials['email'])) {
                $query->where('email', $credentials['email']);
            } elseif (isset($credentials['phone'])) {
                $query->where('phone', $credentials['phone']);
            }
        })->first();

        if (!$user || !isset($credentials['password']) || 
            !password_verify($credentials['password'], $user->password)) {
            return null;
        }

        return $user;
    }
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
