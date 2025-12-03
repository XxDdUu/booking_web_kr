<?php

namespace App\Services;

use App\Repositories\OtpRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\OtpMail;

class OtpRegisterService
{
    protected OtpRepository $otpRepo;
    protected UserRepository $userRepo;

    public function __construct(OtpRepository $otpRepo, UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
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
            Mail::to($contact)->send(new OtpMail($otp));
        }

        // SMS provider
        // SmsService::send($contact, "Your OTP is: $otp");
    }

    public function verifyOtp(string $contact, string $otp): bool
    {
        $stored = $this->otpRepo->get($contact);

        if (!$stored || $stored != $otp) {
            return false;
        }

        $this->otpRepo->markVerified($contact);

        return true;
    }
    public function registerUser(string $contact, ?string $name, string $password, bool $keepLoggedIn = false)
    {
        if (!$this->otpRepo->isVerified($contact)) {
            return [    
                'success' => false,
                'message' => 'OTP not verified'
            ];
        }

        $data = [
            'password' => Hash::make($password),
            'language' => 'en',
        ];
            // Only add name if provided
        if ($name !== null && $name !== '') {
            $data['name'] = $name;
        }

        if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
            $data['email'] = $contact;
        } else {
            $data['phone'] = $contact;
        }

        $user = $this->userRepo->createUser($data);

        if ($keepLoggedIn) {
            $plainToken = Str::random(60);
            $user->remember_token = hash('sha256', $plainToken);
            $user->save();
            return [
                'success' => true,
                'message' => 'Registered successfully',
                'user' => $user,
                'remember_token' => $plainToken,
            ];
        }

        return [
            'success' => true,
            'message' => 'Registered successfully',
            'user' => $user
        ];
    }
}
