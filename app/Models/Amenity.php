<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $table = 'amenity';
    protected $primaryKey = 'Amenity_ID';
    public $timestamps = false;

    protected $fillable = [
        'Amenity_Name',
        'Description',
    ];

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_amenity', 'Amenity_ID', 'Property_ID');
    }
}
