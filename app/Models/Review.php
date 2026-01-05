<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class Review extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'reviewID';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'reviewID',
        'userID',
        'serviceID',
        'rating',
        'review',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class, 'serviceID', 'serviceID');
    }
    public function stay()
    {
        return $this->belongsTo(Stay::class, 'serviceID', 'serviceID');
    }
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($review) {
            if (empty($review->reviewID)) {
                $review->reviewID = 'RVW-' . Str::uuid();
            }
        });
    }
    public static function generateReviewID(string $prefix): string
    {
        return sprintf(
            '%s-%02d-%02d',
            $prefix,
            random_int(10, 99),
            random_int(10, 99),
        );
    }
}
