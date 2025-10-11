<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistributionService extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon_type',
        'icon_data',
        'link',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($service) {
            \Illuminate\Support\Facades\Cache::forget('distribution_services');
        });

        static::deleted(function ($service) {
            \Illuminate\Support\Facades\Cache::forget('distribution_services');
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'asc');
    }

    public function getIconHtmlAttribute()
    {
        switch ($this->icon_type) {
            case 'svg':
                return $this->icon_data;
            case 'font-awesome':
                return '<i class="' . $this->icon_data . '"></i>';
            case 'image':
                return '<img src="' . $this->icon_data . '" alt="' . $this->title . '" class="w-6 h-6">';
            default:
                return $this->icon_data;
        }
    }
}
