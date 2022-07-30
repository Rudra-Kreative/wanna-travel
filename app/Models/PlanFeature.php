<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active',
        'plan_id'
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
