<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminSettings;
use App\Models\FooterSettings;

class AdminDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin settings
        $settings = [
            [
                'key' => 'site_title',
                'value' => 'OSR Digital',
                'type' => 'string',
                'group' => 'general',
                'description' => 'The main site title',
                'is_public' => true,
            ],
            [
                'key' => 'site_description',
                'value' => 'Bringing Stories to Screens Worldwide',
                'type' => 'text',
                'group' => 'general',
                'description' => 'The main site description',
                'is_public' => true,
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@osrdigital.com',
                'type' => 'string',
                'group' => 'contact',
                'description' => 'Main contact email address',
                'is_public' => true,
            ],
            [
                'key' => 'contact_phone',
                'value' => '+1 (555) 123-4567',
                'type' => 'string',
                'group' => 'contact',
                'description' => 'Main contact phone number',
                'is_public' => true,
            ],
            [
                'key' => 'social_media',
                'value' => [
                    'facebook' => 'https://facebook.com/osrdigital',
                    'twitter' => 'https://twitter.com/osrdigital',
                    'linkedin' => 'https://linkedin.com/company/osrdigital',
                    'youtube' => 'https://youtube.com/osrdigital',
                ],
                'type' => 'json',
                'group' => 'social',
                'description' => 'Social media links',
                'is_public' => true,
            ],
        ];

        foreach ($settings as $setting) {
            AdminSettings::create($setting);
        }


        // Create footer settings
        FooterSettings::create([
            'company_name' => 'OSR Digital',
            'company_description' => 'Bringing Stories to Screens Worldwide',
            'address' => '123 Business Street, City, State 12345',
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
                'address' => '123 Business Street, City, State 12345',
                'phone' => '+1 (555) 123-4567',
                'email' => 'info@osrdigital.com',
            ],
            'newsletter_title' => 'Stay Updated',
            'newsletter_description' => 'Subscribe to our newsletter for the latest updates.',
            'newsletter_button_text' => 'Subscribe',
            'is_active' => true,
        ]);

    }
}