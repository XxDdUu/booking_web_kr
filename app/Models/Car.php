<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;
use Str;

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
    protected $appends = ['image_urls'];

    protected $casts = [
        'image' => 'array',
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
    public function getImageUrlsAttribute(): ?array
    {
        return collect($this->image)
            ->map(
                fn($img) =>
                Str::startsWith($img, ['http://', 'https://'])
                    ? $img
                    : Storage::url($img)
            )
            ->toArray();
    }

    public function carRentals()
    {
        $this->hasMany(CarRental::class, 'carID', 'carID');
    }
}
