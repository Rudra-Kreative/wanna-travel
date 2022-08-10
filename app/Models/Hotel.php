<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'contact_name',
        'property_type_id',
        'hotel_type_id',
        'amenity_id',
        'star_rating',
        'phone',
        'address',
        'alternate_address',
        'country',
        'city',
        'zip',
        'is_active'
    ];

    public function creatable()
    {
        return $this->morphTo();
    }

    public function hotelImages()
    {
        return $this->hasMany(HotelImages::class);
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }
}
