<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $table = 'room_types';
    protected $primaryKey = 'RoomTypeID';
    // protected $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'Room_type_ID',
        'Room_type_name'
    ];
}
