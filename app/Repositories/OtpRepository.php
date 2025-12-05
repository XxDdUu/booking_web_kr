<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;

class OtpRepository
{
    public function store(string $contact, string $otp): void
    {
        Cache::put("otp:$contact", $otp, now()->addMinutes(3));
        Cache::put("otp_verified:$contact", false, ttl: now()->addMinutes(10));
    }

    public function get(string $contact): ?string
    {
        return Cache::get("otp:$contact");
    }

    public function markVerified(string $contact): void
    {
        Cache::put("otp_verified:$contact", true, now()->addMinutes(10));
        Cache::forget("otp:$contact");
    }

    public function isVerified(string $contact): bool
    {
        return Cache::get("otp_verified:$contact") === true;
    }
}
