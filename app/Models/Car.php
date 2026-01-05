<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'cars';
    protected $primaryKey = 'carID';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'carName',
        'seatQuantity',
        'luggageQuantity',
        'mileageLimit',
        'image',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($car) {
            if (empty($car->carID)) {
                $car->carID = self::generateCarID('CAR');
            };
        });
    }
    public static function generateCarID(string $prefix): string
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
