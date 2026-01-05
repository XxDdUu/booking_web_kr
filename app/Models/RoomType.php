<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class RoomType extends Model
{
    protected $table = 'roomTypes';
    protected $primaryKey = 'roomTypeID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'roomTypeID',
        'roomType'
    ];
    public function rooms() {
        return $this->hasMany(Room::class, 'roomTypeID', 'roomTypeID');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($roomType){
            if(empty($roomType->roomTypeID)){
                $roomType->roomTypeID = self::generateRoomTypeID('RType');
            }
        });
    }
    public static function generateRoomTypeID(string $prefix): string
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
