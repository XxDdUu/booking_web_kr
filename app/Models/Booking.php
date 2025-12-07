<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCELLED = 'canceled';
    const STATUS_CONFIRMED_MODIFIED = 'confirmed modified';
    const STATUS_PENDING = 'pending';

    protected $fillable = ['user_id', 'service_id','status'];
}
