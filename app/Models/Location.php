<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';
    protected $primaryKey = 'LocationID';
    protected $fillable = [
        'Name',
        'Address',
        'Country',
        'City',
        'PinCode',
        'Image'
    ];
}
