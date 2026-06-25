<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Renter extends Model
{
    protected $table = 'renter';
    protected $primaryKey = 'User_ID';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'User_ID',
        'Move_In_Date',
    ];

    protected function casts(): array
    {
        return [
            'Move_In_Date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID', 'User_ID');
    }
}
