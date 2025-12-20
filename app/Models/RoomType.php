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

    public static function boot()
    {
        parent::boot();
        static::creating(function ($roomType){
            if(empty($roomType->roomTypeID)){
                $roomType->roomTypeID = 'RType-'.Str::uuid();
            }
        });
    }

}
