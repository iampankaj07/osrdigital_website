<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSlider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
        'button_text',
        'button_url',
        'button_text_secondary',
        'button_url_secondary',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Scope for active slides
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered slides
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Check if primary button should be displayed
     */
    public function shouldShowButton()
    {
        return !empty($this->button_text) && !empty($this->button_url);
    }

    /**
     * Check if secondary button should be displayed
     */
    public function shouldShowSecondaryButton()
    {
        return !empty($this->button_text_secondary) && !empty($this->button_url_secondary);
    }
}
