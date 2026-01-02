<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;
use Storage;
class Location extends Model
{
    protected $table = 'locations';
    protected $primaryKey = 'locationID';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'locationID',
        'locationName',
        'address',
        'country',
        'pinCode',
        'location_image_path',
    ];
    protected $appends = ['image_url'];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($location) {
            if (empty($location->locationID)) {
                $location->locationID = self::generateLocationID('LOC');
            };
        });
    }
    public static function generateLocationID(string $prefix): string
    {
        return sprintf(
            '%s-%02d-%02d-%04d',
            $prefix,
            random_int(10, 99),
            random_int(10, 99),
            random_int(1000, 9999)
        );
    }
    public function stays()
    {
        return $this->hasMany(
            Stay::class,
            'locationID',
            'locationID'
        );
    }
    public function scopeNameLikeBinary($query, string $keyword)
    {
        return $query->where(
            'locationName',
            'LIKE BINARY',
            "%{$keyword}%"
        );
    }
    public function getImageUrlAttribute(): ?string
    {
        $path = $this->location_image_path;

        if (! $path) return null;

        return Str::startsWith($path, ['http://', 'https://'])
            ? $path
            : Storage::url($path);
    }

}
