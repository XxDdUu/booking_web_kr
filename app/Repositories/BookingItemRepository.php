<?php

namespace App\Repositories;
use App\Models\BookingItem;
use App\Models\Booking;
class BookingItemRepository 
{
    public function createBookingItem(
        Booking $booking, 
        array $item, 
        float|int $subtotal,
        ?string $checkIn,
        ?string $checkOut): BookingItem
    {
        return BookingItem::create([
            'bookingID' => $booking->bookingID,
            'serviceID' => $item['serviceID'],
            'serviceType' => $item['serviceType'],
            'quantity' => $item['quantity'],
            'check_in'    => $checkIn,
            'check_out'   => $checkOut,
            'subtotal' => $subtotal,
            'status' => 'pending',
            'metaJson' => $item['metaJson'] ?? null
        ]);
    }
    public function updateBookingItemStatus(Booking $booking): void
    {
        BookingItem::where('bookingID', $booking->bookingID)
            ->update(['status' => 'confirmed']);
    }
}