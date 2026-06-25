<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $table = 'inquiry';
    protected $primaryKey = 'Inquiry_ID';
    public $timestamps = false;

    protected $fillable = [
        'User_ID',
        'Listing_ID',
        'Message',
        'Inquiry_Date',
        'Inquiry_Status',
    ];

    protected function casts(): array
    {
        return [
            'Inquiry_Date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID', 'User_ID');
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class, 'Listing_ID', 'Listing_ID');
    }
}
