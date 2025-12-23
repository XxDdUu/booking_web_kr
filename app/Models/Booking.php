<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public $table = 'bookings';
    public $incrementing = false;
    // const STATUS_CONFIRMED = 'confirmed';
    // const STATUS_CANCELLED = 'canceled';
    // const STATUS_CONFIRMED_MODIFIED = 'confirmed modified';
    // const STATUS_PENDING = 'pending';

    protected $fillable = [
        'userID',
        'serviceID',
        // 'status'
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($bookings) {
            if (empty($bookings->bookingID)) {
                $bookings->bookingID = self::createBookingID('BKG');
            };
        });
    }
    public static function createBookingID(string $prefix): string
    {
        return sprintf(
            '%s-%02d-%02d-%04d',
            $prefix,
            random_int(10, 99),
            random_int(10, 99),
            random_int(1000, 9999)
        );
    }
}
