<?php

namespace App\Services;

use App\Repositories\BookingRepository;
use App\Repositories\BookingItemRepository;
use App\Repositories\PaymentRepository;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function __construct(
      protected BookingRepository $bookingRepo,
      protected BookingItemRepository $bookingItemRepo,
      protected PaymentRepository $paymentRepo
    ) {}

    public function createBooking($user, $request): array
    {
        return DB::transaction(function () use ($user, $request) {

            $booking = $this->bookingRepo->createBooking($user);

            $bookingItems = [];
            $totalAmount = 0;

            // 2. Tạo booking items + tính tiền
            foreach ($request->items as $item) {

                $price = $item['metaJson']['price'];
                $days  = $item['metaJson']['days'];
                $qty   = $item['quantity'];

                $checkIn  = $item['check_in']  ?? null;
                $checkOut = $item['check_out'] ?? null;

                if (in_array($item['serviceType'], ['ROOM', 'CAR'])) {
                    if (!$checkIn || !$checkOut || $checkIn >= $checkOut) {
                        throw new \Exception('Invalid Check-in / Check-out');
                    }
                }

                $subtotal = $price * $days * $qty;
                $totalAmount += $subtotal;

                $bookingItem = $this->bookingItemRepo->createBookingItem(
                    $booking,
                    $item,
                    $subtotal,
                    $checkIn,
                    $checkOut
                );

                $bookingItems[] = $bookingItem;
            }


            // 3. Tạo payment (gắn với BOOKING ITEM ĐẦU TIÊN hoặc booking)
            // Nếu sau này muốn 1 payment / booking → đổi design
            $payment = $this->paymentRepo->createPayment(
                $bookingItems[0],
                $totalAmount,
                $request
            );

            // 4. Nếu pay at stay → confirm luôn
            if ($request->paymentMethod === 'stay') {
                $this->bookingItemRepo->updateBookingItemStatus($booking);
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
