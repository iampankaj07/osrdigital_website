<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Associate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'website',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope a query to only include active associates.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order associates.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get the logo URL with proper image handling
     */
    public function getLogoUrlAttribute()
    {
        return ImageHelper::getContextualImage(
            $this->attributes['logo'] ?? null,
            'logo',
            ['width' => 200, 'height' => 100, 'text' => $this->name]
        );
    }

    /**
     * Get the logo URL for admin display
     */
    public function getAdminLogoUrlAttribute()
    {
        return ImageHelper::getContextualImage(
            $this->attributes['logo'] ?? null,
            'logo',
            ['width' => 150, 'height' => 75, 'text' => $this->name]
        );
    }

    /**
     * Get the logo URL for frontend display
     */
    public function getFrontendLogoUrlAttribute()
    {
        return ImageHelper::getContextualImage(
            $this->attributes['logo'] ?? null,
            'logo',
            ['width' => 200, 'height' => 100, 'text' => $this->name]
        );
    }

}
