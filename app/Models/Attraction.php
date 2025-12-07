<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
    protected $table = 'attractions';
    protected $primaryKey = 'attractionID';
    public $incrementing = false; // vì PK là VARCHAR
    protected $keyType = 'string';

    protected $fillable = [
        'serviceID',
        'locationID',
        'categoryID',
        'attractionName',
        'specificType',
        'category',
        'duration',
        'price',
        'image',
    ];
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($attraction) {
            if (empty($attraction->attractionID)) {
                $attraction->attractionID = self::generateStayID('ATT');
            };
        });
    }
    public static function generateStayID(string $prefix): string
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
