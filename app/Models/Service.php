<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    protected $table = 'services';
    protected $primaryKey = 'serviceId';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'serviceType',
    ];
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($service) {
            if (empty($service->serviceID)) {
                $service->serviceID = self::generateServiceID('SV');
            };
        });
    }
    public static function generateServiceID(string $prefix): string
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
