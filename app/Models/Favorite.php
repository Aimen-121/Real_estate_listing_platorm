<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favorite_listing';
    protected $primaryKey = 'Favorite_ID';
    public $timestamps = false;

    protected $fillable = [
        'User_ID',
        'Listing_ID',
        'Saved_Date',
    ];

    protected function casts(): array
    {
        return [
            'Saved_Date' => 'date',
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
