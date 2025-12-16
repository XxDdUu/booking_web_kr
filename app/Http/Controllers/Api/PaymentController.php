<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\BookingItem;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        $request->validate([
            'bookingItemID' => 'required',
            'paymentMethod' => 'required|in:stay,qr,card',
        ]);

        $item = BookingItem::findOrFail($request->bookingItemID);

        $payment = Payment::create([
            'bookingItemID' => $item->BookingItemID,
            'amount' => $item->subtotal,
            'paymentMethod' => $request->paymentMethod,
            'transactionID' => Str::uuid(),
            'status' => $request->paymentMethod === 'stay'
                ? 'Successful'
                : 'Pending',
        ]);

        // Pay at stay → confirm ngay
        if ($request->paymentMethod === 'stay') {
            $item->update(['paymentStatus' => 'PAID']);
        }

        return response()->json([
            'paymentID' => $payment->PaymentID,
            'redirect_url' => $request->paymentMethod !== 'stay'
                ? '/payment/redirect/mock'
                : null,
        ]);
    }
}
