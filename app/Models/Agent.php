<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = 'agent';
    protected $primaryKey = 'User_ID';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'User_ID',
        'Agency_Name',
        'License_Number',
        'Experience_Years',
        'Rating',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID', 'User_ID');
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'Agent_ID', 'User_ID');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'Agent_ID', 'User_ID');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'Agent_ID', 'User_ID');
    }
}
