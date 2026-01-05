<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Models\BookingItem;
use Str;

class PaymentRepository
{
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
}