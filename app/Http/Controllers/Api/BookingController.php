<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Payment;
use App\Services\BookingService;
use App\Services\TokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // Lấy user từ token
        $token = $this->tokenService->extractToken(
            $request->header('Authorization')
        );
        $user = $this->tokenService->getUserFromToken($token);

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Validate
        $request->validate([
            'items' => 'required|array|min:1',
            'paymentMethod' => 'required|in:stay,qr,card',
        ]);

        try {
            $createBooking = $this->bookingService->createBookingAfterClick($user, $request);
            return response()->json([
                'booking' => $createBooking['booking'],
                'bookingItem' => $createBooking['bookingItem'],
            ]);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Booking failed'], 500);
        }
    }
}