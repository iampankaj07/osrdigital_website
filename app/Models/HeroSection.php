<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'content',
        'button_text',
        'button_url',
        'button_text_secondary',
        'button_url_secondary',
        'background_type',
        'background_color',
        'background_image',
        'text_color',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope for active hero sections
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordering by sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Get active hero sections for home page
     */
    public static function getActiveForHome()
    {
        return self::active()->ordered()->get();
    }

    /**
     * Get hero section by page (legacy method for compatibility)
     */
    public static function getByPage($page)
    {
        return self::active()->first();
    }

    /**
     * Get available pages (legacy method for compatibility)
     */
    public static function getAvailablePages()
    {
        return ['home', 'about', 'services', 'contact'];
    }
}

