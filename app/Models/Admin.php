<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'User_ID';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'User_ID',
        'Admin_Role',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID', 'User_ID');
    }
}
