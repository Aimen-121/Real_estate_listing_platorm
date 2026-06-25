<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'review';
    protected $primaryKey = 'Review_ID';
    public $timestamps = false;

    protected $fillable = [
        'User_ID',
        'Booking_ID',
        'Property_ID',
        'Agent_ID',
        'Rating',
        'Comment',
        'Review_Date',
    ];

    protected function casts(): array
    {
        return [
            'Review_Date' => 'date',
            'Rating' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID', 'User_ID');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'Booking_ID', 'Booking_ID');
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'Property_ID', 'Property_ID');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'Agent_ID', 'User_ID');
    }
}
