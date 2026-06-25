<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'property';
    protected $primaryKey = 'Property_ID';
    public $timestamps = false;

    protected $fillable = [
        'Owner_ID',
        'Agent_ID',
        'Category_ID',
        'Title',
        'Description',
        'Location',
        'City',
        'State',
        'Zip_Code',
        'Area_Size',
        'Bedrooms',
        'Bathrooms',
        'Property_Type',
        'Price',
        'Availability_Status',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'Owner_ID', 'User_ID');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'Agent_ID', 'User_ID');
    }

    public function category()
    {
        return $this->belongsTo(PropertyCategory::class, 'Category_ID', 'Category_ID');
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class, 'Property_ID', 'Property_ID');
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'property_amenity', 'Property_ID', 'Amenity_ID');
    }

    public function listings()
    {
        return $this->hasMany(Listing::class, 'Property_ID', 'Property_ID');
    }

    public function paymentSchemes()
    {
        return $this->hasMany(PaymentScheme::class, 'Property_ID', 'Property_ID');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'Property_ID', 'Property_ID');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'Property_ID', 'Property_ID');
    }
}
