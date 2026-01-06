<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Str;
use Storage;

class Room extends Model
{
    protected $table = 'rooms';
    protected $primaryKey = 'RoomID';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
        'image' => 'array',
        'currentPrice' => 'decimal:2',
    ];
    protected $fillable = [
        'roomID',
        'stayID',
        'roomTypeID',
        'roomName',
        'description',
        'quantity',
        'capacity',
        'currentPrice',
        'availability',
        'image'
    ];
    protected $appends = [
        'image_urls',
        'roomType'
    ];
    protected $hidden = ['roomTypeRelation'];
    
    public function stay()
    {
        return $this->belongsTo(Stay::class, 'stayID', 'stayID');
    }

    public function roomTypeRelation()
    {
        return $this->belongsTo(
            RoomType::class,
            'roomTypeID',
            'roomTypeID'
        );
    }
    public function getRoomTypeAttribute()
    {
        return $this->roomTypeRelation?->roomType;
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($room){
            if(empty($room->roomID)){
                $room->roomID = self::generateRoomID('ROOM');
            }
        });
    }
    public static function generateRoomID(string $prefix): string
    {
        return sprintf(
            '%s-%02d-%02d-%04d',
            $prefix,
            random_int(10, 99),
            random_int(10, 99),
            random_int(1000, 9999)
        );
    }
    public function getImageUrlsAttribute(): ?array
    {
        return collect($this->image)
            ->map(fn ($img) =>
                Str::startsWith($img, ['http://', 'https://'])
                    ? $img
                    : Storage::url($img)
            )
            ->toArray();
    }
    public function scopeAvailableBetween($query, $checkIn, $checkOut)
    {
        return $query
            ->leftJoin('booking_items', function ($join) use ($checkIn, $checkOut) {
                $join->on('rooms.roomID', '=', 'booking_items.serviceID')
                    ->where('booking_items.serviceType', 'ROOM')
                    ->where('booking_items.check_in', '<', $checkOut)
                    ->where('booking_items.check_out', '>', $checkIn);
            })
            ->select(
                'rooms.*',
                DB::raw('rooms.quantity - COALESCE(SUM(booking_items.quantity), 0) as available_rooms')
            )
            ->groupBy('rooms.roomID')
            ->having('available_rooms', '>', 0);
    }

}
