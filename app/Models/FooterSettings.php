<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class FooterSettings extends Model
{
    protected $fillable = [
        'company_name',
        'company_description',
        'address',
        'phone',
        'email',
        'website',
        'logo',
        'copyright_text',
        'social_links',
        'quick_links',
        'contact_info',
        'newsletter_title',
        'newsletter_description',
        'newsletter_button_text',
        'is_active',
    ];

    protected $casts = [
        'social_links' => 'array',
        'quick_links' => 'array',
        'contact_info' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($footer) {
            Cache::forget('footer_settings');
        });

        static::deleted(function ($footer) {
            Cache::forget('footer_settings');
        });
    }

    /**
     * Get active footer settings
     */
    public static function getActive()
    {
        return Cache::remember('footer_settings', 3600, function () {
            return static::where('is_active', true)->first() ?? static::getDefault();
        });
    }

    /**
     * Get or create default footer settings
     */
    public static function getDefault()
    {
        $footer = static::where('is_active', true)->first();
        
        if (!$footer) {
            $footer = static::create([
                'company_name' => 'OSR Digital',
                'company_description' => 'Bringing Stories to Screens Worldwide',
                'address' => 'Your Company Address',
                'phone' => '+1 (555) 123-4567',
                'email' => 'info@osrdigital.com',
                'website' => 'https://osrdigital.com',
                'copyright_text' => '© 2024 OSR Digital. All rights reserved.',
                'social_links' => [
                    'facebook' => 'https://facebook.com/osrdigital',
                    'twitter' => 'https://twitter.com/osrdigital',
                    'linkedin' => 'https://linkedin.com/company/osrdigital',
                    'youtube' => 'https://youtube.com/osrdigital',
                ],
                'quick_links' => [
                    ['title' => 'About Us', 'url' => '/about'],
                    ['title' => 'Services', 'url' => '/services'],
                    ['title' => 'Portfolio', 'url' => '/portfolio'],
                    ['title' => 'Contact', 'url' => '/contact'],
                ],
                'contact_info' => [
                    'address' => 'Your Company Address',
                    'phone' => '+1 (555) 123-4567',
                    'email' => 'info@osrdigital.com',
                ],
                'newsletter_title' => 'Stay Updated',
                'newsletter_description' => 'Subscribe to our newsletter for the latest updates.',
                'newsletter_button_text' => 'Subscribe',
                'is_active' => true,
            ]);
        }

        return $footer;
    }
}
