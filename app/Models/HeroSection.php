<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'page',
        'title',
        'subtitle',
        'content',
        'button_text',
        'button_link',
        'button_text_secondary',
        'button_link_secondary',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Get the available pages for hero sections
     */
    public static function getAvailablePages()
    {
        return [
            'home' => 'Home',
            'about' => 'About',
            'partners' => 'Partners',
            'team' => 'Team',
            'news' => 'News',
            'portfolio' => 'Portfolio',
            'contact' => 'Contact',
            'business' => 'Business'
        ];
    }

    /**
     * Get hero section by page
     */
    public static function getByPage($page)
    {
        return self::where('page', $page)
                   ->where('is_active', true)
                   ->orderBy('sort_order')
                   ->first();
    }

    /**
     * Check if button should be displayed
     */
    public function shouldShowButton()
    {
        return !empty($this->button_text) && !empty($this->button_link);
    }

    /**
     * Check if secondary button should be displayed
     */
    public function shouldShowSecondaryButton()
    {
        return !empty($this->button_text_secondary) && !empty($this->button_link_secondary);
    }
}