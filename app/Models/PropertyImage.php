<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    protected $table = 'property_image';
    protected $primaryKey = 'Image_ID';
    public $timestamps = false;

    protected $fillable = [
        'Property_ID',
        'Image_Path',
        'Upload_Date',
        'Caption',
    ];

    protected function casts(): array
    {
        return [
            'Upload_Date' => 'date',
        ];
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'Property_ID', 'Property_ID');
    }
}
