<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';
    protected $primaryKey = 'Booking_ID';
    public $timestamps = false;

    protected $fillable = [
        'User_ID',
        'Property_ID',
        'Owner_ID',
        'Agent_ID',
        'Visit_Date',
        'Visit_Time',
        'Booking_Status',
    ];

    protected function casts(): array
    {
        return [
            'Visit_Date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID', 'User_ID');
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'Property_ID', 'Property_ID');
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'Owner_ID', 'User_ID');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'Agent_ID', 'User_ID');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'Booking_ID', 'Booking_ID');
    }
}
