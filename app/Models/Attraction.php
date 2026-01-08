<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Storage;
use Str;


class Attraction extends Model
{
    protected $table = 'attractions';
    protected $primaryKey = 'attractionID';
    public $incrementing = false; // vì PK là VARCHAR
    protected $keyType = 'string';

    protected $fillable = [
        'serviceID',
        'locationID',
        'categoryID',
        'attractionName',
        'specificType',
        'category',
        'duration',
        'price',
        'image',
    ];

    protected $casts = [
        'image' => 'array',
        'price' => 'decimal:2',
        'rate' => 'decimal:1'
    ];

    protected $appends = ['image_urls'];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($attraction) {
            if (empty($attraction->attractionID)) {
                $attraction->attractionID = self::generateAttractionID('ATT');
            };
        });
    }
    public static function generateAttractionID(string $prefix): string
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
            ->map(
                fn($img)
                => Str::startsWith($img, ['http://', 'https://'])
                    ? $img
                    : Storage::url($img)
            )->toArray();
    }

    public function category(){
        return $this->belongsTo(Category::class,'categoryID','categoryID');
    }
    public function location(){
        return $this->belongsTo(Location::class, 'locationID','locationID');
    }

    public function service(){
        return $this->belongsTo(Service::class,'serviceID','serviceID');
    }
}
