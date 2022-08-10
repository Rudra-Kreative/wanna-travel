<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelImages extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'hotel_id',
        'image',
        'is_active'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
