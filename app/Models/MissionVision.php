<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissionVision extends Model
{
    protected $fillable = [
        'mission_title',
        'mission_description',
        'mission_icon',
        'vision_title',
        'vision_description',
        'vision_icon',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
