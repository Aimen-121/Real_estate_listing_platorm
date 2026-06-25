<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyCategory extends Model
{
    protected $table = 'property_category';
    protected $primaryKey = 'Category_ID';
    public $timestamps = false;

    protected $fillable = [
        'Category_Name',
        'Category_Type',
    ];

    public function properties()
    {
        return $this->hasMany(Property::class, 'Category_ID', 'Category_ID');
    }
}
