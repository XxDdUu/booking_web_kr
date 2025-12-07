<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingValidateController extends Controller
{
    //
    public function updateStatus(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    Booking::STATUS_CONFIRMED,
                    Booking::STATUS_CONFIRMED_MODIFIED,
                    Booking::STATUS_CANCELLED,
                    Booking::STATUS_PENDING
                ])
            ]
        ]);
    }
}
