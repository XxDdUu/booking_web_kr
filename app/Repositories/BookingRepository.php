<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\BookingItem;

class BookingRepository
{
    public function createBooking(Booking $user): Booking {
        return Booking::create([
                'userID' => $user->id,
                'status' => 'Pending',
            ]);
    }
    public function createBookingItem(Booking $booking, array $item, float|int $subtotal): BookingItem{
        return BookingItem::create([
                    'bookingID' => $booking->bookingID,
                    'serviceID' => $item['serviceID'],
                    'serviceType' => $item['serviceType'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                    'paymentStatus' => 'UNPAID',
                    'metaJson' => json_encode($item['meta'])
        ]);
    }
}
