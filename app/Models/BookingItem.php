<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingItem extends Model
{
    protected $table = 'bookingItems';
    protected $primaryKey = 'bookingItemID';
    public $incrementing = false; // vì PK là VARCHAR
    protected $keyType = 'string';

    protected $fillable = [
        'bookingID',
        'serviceID',
        'serviceType',
        'quantity',
        'subtotal',
        'metaJson'
    ];
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($bookingItem) {
            if (empty($bookingItem->bookingItemID)) {
                $bookingItem->bookingItemID = self::generateBkgItemID('BKGITEM');
            };
        });
    }
    public static function generateBkgItemID(string $prefix): string
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
