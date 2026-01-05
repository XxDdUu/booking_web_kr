<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Log;
use App\Services\OtpRegisterService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class AuthOtpRegisterController extends Controller
{
    protected OtpRegisterService $otpRegisterService;   

    public function __construct(OtpRegisterService $otpRegisterService)
    {
        $this->otpRegisterService = $otpRegisterService;
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'contact' => 'required|string',
        ]);

        $otp = $this->otpRegisterService->generateOtp($request->contact);
        $this->otpRegisterService->sendOtp(
            contact: $request->contact, 
            otp: $otp
        );

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

        $valid = $this->otpRegisterService->verifyOtp($request->contact, $request->otp);

        return $valid
            ? response()->json(['success' => true, 'message' => 'Verified'])
            : response()->json(['success' => false, 'message' => 'Invalid or expired OTP'], 400);
    }
    public function register(Request $request) {
        $contact = $request->contact;
        if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
            $request->merge(['email' => $contact]);
        } else {
            $request->merge(['phone' => $contact]);
        }
        $request->request->remove('contact');
        $request->validate([
        'name' => ['nullable','string', 'max:255'],

        'email' => [
            'string',
            'email',
            'max:255',
            'unique:users,email',
            'required_without:phone',
        ],

        'phone' => [
            'string',
            'max:255',
            'unique:users,phone',
            'required_without:email',
        ],

        'password' => ['required', 'string', 'min:8'],
        'keepLoggedIn' => ['nullable', 'boolean'],
        ]);
        return $this->otpRegisterService->registerUser(
            $contact,
            $request->name,
            $request->password,
            $request->keepLoggedIn
    );
    }
}
