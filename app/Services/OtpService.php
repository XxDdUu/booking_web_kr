<?php

namespace App\Services;

use App\Repositories\OtpRepository;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    protected OtpRepository $otpRepo;

    public function __construct(OtpRepository $otpRepo)
    {
        $this->otpRepo = $otpRepo;
    }

    public function generateOtp(string $contact): int
    {
        $otp = rand(100000, 999999);
        $this->otpRepo->store($contact, $otp);
        return $otp;
    }

    public function sendOtp(string $contact, int $otp): void
    {
        if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
            Mail::raw("Your OTP is: {$otp}", function ($m) use ($contact) {
                $m->to($contact)->subject("Your OTP Code");
            });
        }

        // SMS provider (tùy bạn)
        // Ví dụ:
        // SmsService::send($contact, "Your OTP is: $otp");
    }

    public function verifyOtp(string $contact, string $otp): bool
    {
        $stored = $this->otpRepo->get($contact);

        if (!$stored || $stored != $otp) {
            return false;
        }

        $this->otpRepo->delete($contact);

        return true;
    }
}
