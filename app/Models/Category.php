<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'categoryID';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'categoryName',
    ];
     protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($category) {
            if (empty($category->categoryID)) {
                $category->categoryID = self::generateCategoryID('CATE');
            };
        });
    }
    public static function generateCategoryID(string $prefix): string
    {
        return sprintf(
            '%s-%02d-%02d-%04d',
            $prefix,
            random_int(10, 99),
            random_int(10, 99),
            random_int(1000, 9999)
        );
    }
}
