<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $table = 'buyer';
    protected $primaryKey = 'User_ID';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'User_ID',
        'Preference',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID', 'User_ID');
    }
}
