<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Room;

class Stay extends Model
{
    protected $table = 'stays';
    protected $primaryKey = 'stayID';
    public $incrementing = false; // vì PK là VARCHAR
    protected $keyType = 'string';

    protected $fillable = [
        'locationID',
        'categoryID',
        'serviceID',
        'stayName',
        // 'checkIn',
        // 'checkOut',
        'description',
        'location',
        'rate', 
        'address',
        'image',
        'price'
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'stayID', 'stayID');
    }
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($stay) {
            if (empty($stay->stayID)) {
                $stay->stayID = self::generateStayID('STAY');
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
