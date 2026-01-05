<?php

namespace App\Repositories;

use App\Models\Booking;
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
}
