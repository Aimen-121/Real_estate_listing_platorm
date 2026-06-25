<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $table = 'listing';
    protected $primaryKey = 'Listing_ID';
    public $timestamps = false;

    protected $fillable = [
        'Property_ID',
        'Created_By',
        'Listing_Type',
        'Price',
        'Listing_Date',
        'Expire_Date',
        'Status',
        'Description',
        'Featured_Flag',
        'Total_Views',
    ];

    protected function casts(): array
    {
        return [
            'Listing_Date' => 'date',
            'Expire_Date' => 'date',
            'Featured_Flag' => 'boolean',
            'Total_Views' => 'integer',
        ];
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'Property_ID', 'Property_ID');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'Created_By', 'User_ID');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'Listing_ID', 'Listing_ID');
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class, 'Listing_ID', 'Listing_ID');
    }
}
