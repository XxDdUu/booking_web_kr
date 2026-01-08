<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Str;
use Storage;
use Illuminate\Database\Eloquent\Builder;
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
   public function scopeWithAvailabilityBetween(
        Builder $query,
        string $stayID,
        string $checkIn,
        string $checkOut
    ) {
        return $query->where('stayID', $stayID)
            ->select('rooms.*')
            ->selectRaw('(rooms.quantity - COALESCE((
                SELECT SUM(bi.quantity)
                FROM bookingItems bi
                WHERE bi.stayID = rooms.stayID
                AND bi.roomTypeID = rooms.roomTypeID
                AND bi.check_in < ?
                AND bi.check_out > ?
            ), 0)) as availableQuantity', [$checkOut, $checkIn]);
    }


}
