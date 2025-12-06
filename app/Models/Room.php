<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    protected $primaryKey = 'RoomID';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'RoomID',
        'HotelID',
        'Room_type_ID',
        'Room_name',
        'Description',
        'Current_price'
    ];

    public function stay()
    {
        return $this->belongsTo(Stay::class, 'HotelID', 'HotelID');
    }

    public function roomType()
    {
        // return $this->belongsTo(RoomType::class, 'Room_type_ID', 'Room_type_ID');
    }
}
