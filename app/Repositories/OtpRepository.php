<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;

class OtpRepository
{
    protected int $ttl = 300; // 5 phút (300s)

    public function store(string $contact, int $otp): void
    {
        Cache::put("otp_{$contact}", $otp, now()->addSeconds($this->ttl));
    }

    public function get(string $contact): ?int
    {
        return Cache::get("otp_{$contact}");
    }

    public function delete(string $contact): void
    {
        Cache::forget("otp_{$contact}");
    }
}
