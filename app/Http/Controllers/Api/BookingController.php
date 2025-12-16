<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Payment;
use App\Services\TokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    protected TokenService $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
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
            'payment_method' => 'required|in:stay,qr,card',
        ]);

        DB::beginTransaction();

        try {
            // Tạo booking tổng
            $booking = Booking::create([
                'userID' => $user->id,
                'status' => 'Pending',
                'date' => now(),
            ]);

            $bookingItems = [];

            foreach ($request->items as $item) {
                $subtotal = $item['meta']['price'] * $item['quantity'];

                $bookingItems[] = BookingItem::create([
                    'bookingID' => $booking->BookingID,
                    'serviceID' => $item['serviceID'],
                    'serviceType' => $item['serviceType'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                    'paymentStatus' => 'UNPAID',
                    'metaJson' => json_encode($item['meta']),
                ]);
            }

            DB::commit();

            return response()->json([
                'bookingID' => $booking->BookingID,
                'items' => $bookingItems,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => 'Booking failed'], 500);
        }
    }
}