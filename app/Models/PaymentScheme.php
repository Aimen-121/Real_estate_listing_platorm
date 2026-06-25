<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentScheme extends Model
{
    protected $table = 'payment_scheme';
    protected $primaryKey = 'Scheme_ID';
    public $timestamps = false;

    protected $fillable = [
        'Property_ID',
        'Scheme_Name',
        'Scheme_Type',
        'Advance_Percentage',
        'Installment_Months',
        'Description',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'Property_ID', 'Property_ID');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'Scheme_ID', 'Scheme_ID');
    }
}
