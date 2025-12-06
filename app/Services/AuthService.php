<?php

namespace App\Services;

use App\Repositories\AuthRepository;

class AuthService
{
    protected $repo;

    public function __construct(AuthRepository $repo)
    {
        $this->repo = $repo;
    }

    public function extractToken($header): ?string
    {
        if (!$header) return null;
        return str_replace("Bearer ", "", $header);
    }

    public function getUserFromToken(?string $token)
    {
        if (!$token) return null;

        $hashed = hash('sha256', $token);
        return $this->repo->findUserByToken($hashed);
    }

    public function logoutUser($user): void
    {
        $this->repo->removeToken($user);
    }
}
