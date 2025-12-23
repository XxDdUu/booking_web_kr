<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BookingService;
use App\Services\TokenService;
use Illuminate\Http\Request;
use Log;

class BookingController extends Controller
{
    protected TokenService $tokenService;
    protected BookingService $bookingService;

    public function __construct(TokenService $tokenService, BookingService $bookingService)
    {
        $this->tokenService = $tokenService;
        $this->bookingService = $bookingService;
    }

    public function store(Request $request)
    {
        \Log::info('AUTH HEADER', [
            'authorization' => $request->header('Authorization')
        ]);

        $token = $this->tokenService->extractToken(
            $request->header('Authorization')
        );
        \Log::info("Token", ["token" => $token]);

        $user = $this->tokenService->getUserFromToken($token);
        \Log::info("User", ["user" => $user]);

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'items' => 'required|array|min:1',
            'paymentMethod' => 'required|in:stay,qr,card',
        ]);

        try {
            $result = $this->bookingService
                ->createBookingAfterClick($user, $request);

            return response()->json($result);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Booking failed',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }
}
