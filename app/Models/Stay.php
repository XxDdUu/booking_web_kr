<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Room;

class Stay extends Model
{
    protected $table = 'stays';
    protected $primaryKey = 'HotelID';
    public $incrementing = false; // vì PK là VARCHAR
    protected $keyType = 'string';

    protected $fillable = [
        'HotelID',
        'LocationID',
        'CategoryID',
        'ServiceID',
        'ReviewID', 
        'Hotel_name',
        'checkIn',
        'checkOut',
        'Description',
        'City',
        'Image'
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'HotelID', 'HotelID');
    }
}
