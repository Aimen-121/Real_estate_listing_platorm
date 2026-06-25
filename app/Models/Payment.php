<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $primaryKey = 'Payment_ID';
    public $timestamps = false;

    protected $fillable = [
        'User_ID',
        'Scheme_ID',
        'Amount',
        'Payment_Date',
        'Payment_Method',
        'Payment_Status',
    ];

    protected function casts(): array
    {
        return [
            'Payment_Date' => 'date',
            'Amount' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID', 'User_ID');
    }

    public function scheme()
    {
        return $this->belongsTo(PaymentScheme::class, 'Scheme_ID', 'Scheme_ID');
    }
}
