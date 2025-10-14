<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LegalPage extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'page_type',
        'content',
        'excerpt',
        'meta_title',
        'meta_description',
        'is_published',
        'last_updated_at',
        'updated_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'last_updated_at' => 'datetime',
    ];

    const PAGE_TYPES = [
        'privacy_policy' => 'Privacy Policy',
        'terms_of_service' => 'Terms of Service',
        'cookies_policy' => 'Cookies Policy',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });

        static::updating(function ($page) {
            $page->last_updated_at = now();
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('page_type', $type);
    }

    public function getPageTypeNameAttribute()
    {
        return self::PAGE_TYPES[$this->page_type] ?? $this->page_type;
    }

    public static function getDefaultContent($type)
    {
        $content = [
            'privacy_policy' => '<h2>Privacy Policy</h2><p>This Privacy Policy describes how we collect, use, and protect your information when you visit our website.</p><h3>Information We Collect</h3><p>We may collect personal information that you provide directly to us, such as when you contact us or sign up for our services.</p><h3>How We Use Your Information</h3><p>We use the information we collect to provide and improve our services, communicate with you, and comply with legal obligations.</p><h3>Data Protection</h3><p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p><h3>Contact Us</h3><p>If you have any questions about this Privacy Policy, please contact us.</p>',

            'terms_of_service' => '<h2>Terms of Service</h2><p>These Terms of Service govern your use of our website and services.</p><h3>Acceptance of Terms</h3><p>By accessing and using our website, you agree to be bound by these Terms of Service.</p><h3>Use of Services</h3><p>You may use our services for lawful purposes only. You agree not to use our services for any illegal or unauthorized purpose.</p><h3>Intellectual Property</h3><p>All content on our website is protected by copyright and other intellectual property laws.</p><h3>Limitation of Liability</h3><p>We shall not be liable for any damages arising from your use of our website or services.</p><h3>Changes to Terms</h3><p>We reserve the right to modify these terms at any time. Changes will be effective immediately upon posting.</p>',

            'cookies_policy' => '<h2>Cookies Policy</h2><p>This Cookies Policy explains how we use cookies and similar technologies on our website.</p><h3>What Are Cookies</h3><p>Cookies are small text files that are stored on your device when you visit our website.</p><h3>How We Use Cookies</h3><p>We use cookies to improve your browsing experience, analyze website traffic, and provide personalized content.</p><h3>Types of Cookies We Use</h3><ul><li><strong>Essential Cookies:</strong> Necessary for the website to function properly</li><li><strong>Analytics Cookies:</strong> Help us understand how visitors use our website</li><li><strong>Functional Cookies:</strong> Enable enhanced functionality and personalization</li></ul><h3>Managing Cookies</h3><p>You can control and manage cookies through your browser settings. Note that disabling certain cookies may affect website functionality.</p><h3>Updates to This Policy</h3><p>We may update this Cookies Policy from time to time to reflect changes in our practices or applicable laws.</p>',
        ];

        return $content[$type] ?? '';
    }
}
