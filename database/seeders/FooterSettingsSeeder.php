<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class FooterSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $footerSettings = [
            // Footer Logo Settings
            [
                'key' => 'footer_logo_height',
                'value' => '48',
                'type' => 'integer',
                'group' => 'footer',
                'description' => 'Footer logo height in pixels',
                'is_public' => true,
            ],
            [
                'key' => 'footer_logo_width',
                'value' => '120',
                'type' => 'integer',
                'group' => 'footer',
                'description' => 'Footer logo maximum width in pixels',
                'is_public' => true,
            ],
            [
                'key' => 'footer_logo_opacity',
                'value' => '0.9',
                'type' => 'float',
                'group' => 'footer',
                'description' => 'Footer logo opacity (0.0 to 1.0)',
                'is_public' => true,
            ],
            [
                'key' => 'footer_show_logo',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'footer',
                'description' => 'Show logo in footer',
                'is_public' => true,
            ],

            // Footer Company Info
            [
                'key' => 'footer_company_name',
                'value' => 'OSR Digital',
                'type' => 'text',
                'group' => 'footer',
                'description' => 'Company name displayed in footer',
                'is_public' => true,
            ],
            [
                'key' => 'footer_description',
                'value' => 'Bringing stories to screens worldwide through strategic content acquisition and YouTube publishing.',
                'type' => 'textarea',
                'group' => 'footer',
                'description' => 'Footer description text',
                'is_public' => true,
            ],

            // Footer Contact Information
            [
                'key' => 'footer_contact_email',
                'value' => 'hello@osrdigital.com',
                'type' => 'email',
                'group' => 'footer',
                'description' => 'Footer contact email',
                'is_public' => true,
            ],
            [
                'key' => 'footer_contact_phone',
                'value' => '+1 (555) 123-4567',
                'type' => 'text',
                'group' => 'footer',
                'description' => 'Footer contact phone',
                'is_public' => true,
            ],
            [
                'key' => 'footer_contact_address',
                'value' => 'Los Angeles, CA',
                'type' => 'text',
                'group' => 'footer',
                'description' => 'Footer contact address',
                'is_public' => true,
            ],

            // Footer Links
            [
                'key' => 'footer_quick_links',
                'value' => json_encode([
                    ['text' => 'About Us', 'url' => '#about'],
                    ['text' => 'Our Business', 'url' => '#business'],
                    ['text' => 'Portfolio', 'url' => '#portfolio'],
                    ['text' => 'Partners', 'url' => '#partners'],
                ]),
                'type' => 'json',
                'group' => 'footer',
                'description' => 'Footer quick links',
                'is_public' => true,
            ],
            [
                'key' => 'footer_services',
                'value' => json_encode([
                    'Movie Rights Acquisition',
                    'Music Publishing',
                    'Short Film Distribution',
                    'Content Strategy',
                ]),
                'type' => 'json',
                'group' => 'footer',
                'description' => 'Footer services list',
                'is_public' => true,
            ],

            // Footer Copyright
            [
                'key' => 'footer_copyright_text',
                'value' => '© 2025 OSR Digital. All rights reserved.',
                'type' => 'text',
                'group' => 'footer',
                'description' => 'Footer copyright text',
                'is_public' => true,
            ],
        ];

        foreach ($footerSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
