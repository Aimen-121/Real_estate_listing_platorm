<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $table = 'owner';
    protected $primaryKey = 'User_ID';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'User_ID',
        'Ownership_Type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID', 'User_ID');
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'Owner_ID', 'User_ID');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'Owner_ID', 'User_ID');
    }
}
