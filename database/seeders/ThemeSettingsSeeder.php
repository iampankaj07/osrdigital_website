<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThemeSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Branding Settings
            [
                'key' => 'site_logo',
                'value' => null,
                'type' => 'image',
                'group' => 'branding',
                'description' => 'Site Logo',
                'is_public' => true,
            ],
            [
                'key' => 'site_favicon',
                'value' => null,
                'type' => 'image',
                'group' => 'branding',
                'description' => 'Site Favicon',
                'is_public' => true,
            ],
            [
                'key' => 'company_name',
                'value' => 'OSR Digital',
                'type' => 'text',
                'group' => 'branding',
                'description' => 'Company Name',
                'is_public' => true,
            ],
            [
                'key' => 'site_tagline',
                'value' => 'Your digital partner',
                'type' => 'text',
                'group' => 'branding',
                'description' => 'Site Tagline',
                'is_public' => true,
            ],

            // Theme Settings
            [
                'key' => 'primary_color',
                'value' => '#3b82f6',
                'type' => 'color',
                'group' => 'theme',
                'description' => 'Primary Brand Color',
                'is_public' => true,
            ],
            [
                'key' => 'secondary_color',
                'value' => '#64748b',
                'type' => 'color',
                'group' => 'theme',
                'description' => 'Secondary Color',
                'is_public' => true,
            ],
            [
                'key' => 'dark_mode_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'theme',
                'description' => 'Enable Dark Mode',
                'is_public' => true,
            ],

            // General Settings
            [
                'key' => 'contact_email',
                'value' => 'info@osrdigital.com',
                'type' => 'email',
                'group' => 'general',
                'description' => 'Contact Email',
                'is_public' => true,
            ],
            [
                'key' => 'contact_phone',
                'value' => '+1234567890',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Contact Phone',
                'is_public' => true,
            ],
            [
                'key' => 'office_address',
                'value' => '123 Business Street, City, State 12345',
                'type' => 'textarea',
                'group' => 'general',
                'description' => 'Office Address',
                'is_public' => true,
            ],

            // Header Settings
            [
                'key' => 'header_cta_text',
                'value' => 'Get Started',
                'type' => 'text',
                'group' => 'header',
                'description' => 'Header Call-to-Action Text',
                'is_public' => true,
            ],
            [
                'key' => 'header_cta_url',
                'value' => '/contact',
                'type' => 'url',
                'group' => 'header',
                'description' => 'Header Call-to-Action URL',
                'is_public' => true,
            ],

            // Footer Settings
            [
                'key' => 'footer_copyright',
                'value' => 'Copyright © 2025 OSR Digital. All rights reserved.',
                'type' => 'text',
                'group' => 'footer',
                'description' => 'Footer Copyright Text',
                'is_public' => true,
            ],
            [
                'key' => 'footer_description',
                'value' => 'We are your trusted digital partner, providing innovative solutions for modern businesses.',
                'type' => 'textarea',
                'group' => 'footer',
                'description' => 'Footer Description',
                'is_public' => true,
            ],

            // Social Media Settings
            [
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/osrdigital',
                'type' => 'url',
                'group' => 'social',
                'description' => 'Facebook URL',
                'is_public' => true,
            ],
            [
                'key' => 'twitter_url',
                'value' => 'https://twitter.com/osrdigital',
                'type' => 'url',
                'group' => 'social',
                'description' => 'Twitter URL',
                'is_public' => true,
            ],
            [
                'key' => 'linkedin_url',
                'value' => 'https://linkedin.com/company/osrdigital',
                'type' => 'url',
                'group' => 'social',
                'description' => 'LinkedIn URL',
                'is_public' => true,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
