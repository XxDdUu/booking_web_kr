<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Payment;
use App\Models\User;
use Log;
use Str;

class BookingRepository
{
    public function createBooking(User $user): Booking
    {
        return Booking::create([
            'userID' => $user->id,
        ]);
    }
    public function createBookingItem(Booking $booking, array $item, float|int $subtotal): BookingItem
    {
        return BookingItem::create([
            'bookingID' => $booking->bookingID,
            'serviceID' => $item['serviceID'],
            'serviceType' => $item['serviceType'],
            'quantity' => $item['quantity'],
            'subtotal' => $subtotal,
            'status' => 'pending',
            'metaJson' => $item['metaJson']
        ]);
    }

    public function createPayment(BookingItem $bookingItem, float|int $totalAmount, $request): ?Payment
    {
        return Payment::create([
            'bookingItemID' => $bookingItem->bookingItemID,
            'amount' => $totalAmount,
            'paymentMethod' => $request->paymentMethod,
            'transactionID' => (string) Str::uuid(),
            'status' => $request->paymentMethod === 'stay'
                ? 'failed'
                : 'pending',
        ]);
    }

    public function updateBookingItemStatus(Booking $booking): void
    {
        BookingItem::where('bookingID', $booking->bookingID)
            ->update(['status' => 'confirmed']);
    }
}
