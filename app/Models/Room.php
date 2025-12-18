<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class Room extends Model
{
    protected $table = 'rooms';
    protected $primaryKey = 'RoomID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'roomID',
        'stayID',
        'roomTypeID',
        'roomName',
        'description',
        'quantity',
        'currentPrice',
        'availability'
    ];

    public function stay()
    {
        return $this->belongsTo(Stay::class, 'stayID', 'stayID');
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'roomTypeID', 'roomTypeID');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($room){
            if(empty($room->roomID)){
                $room->roomID = 'RType-'.Str::uuid();
            }
        });
    }
}
