<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'paymentID';
    public $incrementing = false; // vì PK là VARCHAR
    protected $keyType = 'string';

    protected $fillable = [
        'bookingItemID',
        'amount',
        'paymentDate',
        'paymentMethod',
        'transactionID',
        'status',
    ];
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($payment) {
            if (empty($payment->paymentID)) {
                $payment->paymentID = self::generatePaymentID('PAY');
            };
        });
    }
    public static function generatePaymentID(string $prefix): string
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
