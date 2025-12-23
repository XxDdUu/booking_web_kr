<?php

namespace App\Services;

use App\Repositories\BookingRepository;
use Illuminate\Support\Facades\DB;

class BookingService
{
    protected BookingRepository $bookingRepo;

    public function __construct(BookingRepository $bookingRepo)
    {
        $this->bookingRepo = $bookingRepo;
    }

    public function createBookingAfterClick($user, $request): array
    {
        return DB::transaction(function () use ($user, $request) {

            // 1. Tạo booking
            $booking = $this->bookingRepo->createBooking($user);

            $bookingItems = [];
            $totalAmount = 0;

            // 2. Tạo booking items + tính tiền
            foreach ($request->items as $item) {

                $price = $item['metaJson']['price'];
                $days  = $item['metaJson']['days'];
                $qty   = $item['quantity'];

                $subtotal = $price * $days * $qty;
                $totalAmount += $subtotal;

                $bookingItem = $this->bookingRepo
                    ->createBookingItem($booking, $item, $subtotal);
                \Log::info('BOOKING ITEM CREATED', [
                    'bookingItem' => $bookingItem
                ]);


                $bookingItems[] = $bookingItem;
            }

            // 3. Tạo payment (gắn với BOOKING ITEM ĐẦU TIÊN hoặc booking)
            // Nếu sau này muốn 1 payment / booking → đổi design
            $payment = $this->bookingRepo->createPayment(
                $bookingItems[0], // BookingItem MODEL
                $totalAmount,
                $request
            );

            // 4. Nếu pay at stay → confirm luôn
            if ($request->paymentMethod === 'stay') {
                $this->bookingRepo->updateBookingItemStatus($booking);
            }

            return [
                'booking' => $booking,
                'bookingItems' => $bookingItems,
                'payment' => $payment,
                'redirect_url' => $request->paymentMethod !== 'stay'
                    ? '/payment/redirect/mock'
                    : null,
            ];
        });
    }
}
