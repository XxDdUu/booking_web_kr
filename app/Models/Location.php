<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';
    protected $primaryKey = 'locationID';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'locationID',
        'locationName',
        'address',
        'country',
        'pinCode',
        'image'
    ];
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($location) {
            if (empty($location->locationID)) {
                $location->locationID = self::generateLocationID('LOC');
            };
        });
    }
    public static function generateLocationID(string $prefix): string
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
