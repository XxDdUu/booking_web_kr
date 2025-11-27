<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    protected $table = 'services';
    protected $primaryKey = 'ServiceId';
    protected $fillable = [
        'LocationID',
        'Name',
        'Description',
        'Price',
    ];

}
