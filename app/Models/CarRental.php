<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarRental extends Model
{
    protected $table = 'carRentals';
    protected $keyType = 'string';
    protected $primaryKey = 'carRentalID';
    public $incrementing = false;
    protected $fillable = [
        'carID',
        'serviceID',
        'locationID',
        'checkInDestination',
        'price',
        'rate',
    ];
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($carRentals) {
            if (empty($carRentals->carRentalID)) {
                $carRentals->carRentalID = self::generateCarRentalID('CR');
            };
        });
    }
    public static function generateCarRentalID(string $prefix): string
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
