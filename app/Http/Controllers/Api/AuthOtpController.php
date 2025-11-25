<?php

namespace App\Http\Controllers\Api;

use App\Services\OtpService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class AuthOtpController extends Controller
{
    protected OtpService $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'contact' => 'required|string',
        ]);

        $otp = $this->otpService->generateOtp($request->contact);
        $this->otpService->sendOtp(contact: $request->contact, $otp);

        return response()->json([
            'success' => true,
            'message' => 'OTP sent',
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'contact' => 'required|string',
            'otp' => 'required|string',
        ]);

        $valid = $this->otpService->verifyOtp($request->contact, $request->otp);

        return $valid
            ? response()->json(['success' => true, 'message' => 'Verified'])
            : response()->json(['success' => false, 'message' => 'Invalid or expired OTP'], 400);
    }
}
