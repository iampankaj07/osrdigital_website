<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Hero Section Settings
            [
                'key' => 'hero_badge_text',
                'value' => 'Digital Media Excellence',
                'type' => 'text',
                'group' => 'hero',
                'description' => 'Text displayed in the hero badge',
                'is_public' => true,
            ],
            [
                'key' => 'hero_main_title',
                'value' => 'Bringing Stories to',
                'type' => 'text',
                'group' => 'hero',
                'description' => 'Main title text in hero section',
                'is_public' => true,
            ],
            [
                'key' => 'hero_highlighted_title',
                'value' => 'Global Screens',
                'type' => 'text',
                'group' => 'hero',
                'description' => 'Highlighted title text in hero section',
                'is_public' => true,
            ],
            [
                'key' => 'hero_description',
                'value' => 'OSR Digital specializes in acquiring exceptional entertainment content and strategically distributing it to worldwide audiences through cutting-edge digital platforms.',
                'type' => 'textarea',
                'group' => 'hero',
                'description' => 'Hero section description text',
                'is_public' => true,
            ],
            [
                'key' => 'hero_primary_button_text',
                'value' => 'Partner With Us',
                'type' => 'text',
                'group' => 'hero',
                'description' => 'Primary button text in hero section',
                'is_public' => true,
            ],
            [
                'key' => 'hero_secondary_button_text',
                'value' => 'Explore Portfolio',
                'type' => 'text',
                'group' => 'hero',
                'description' => 'Secondary button text in hero section',
                'is_public' => true,
            ],

            // Statistics Settings
            [
                'key' => 'stats_movies_count',
                'value' => '500+',
                'type' => 'text',
                'group' => 'stats',
                'description' => 'Number of movies published',
                'is_public' => true,
            ],
            [
                'key' => 'stats_movies_label',
                'value' => 'Movies Published',
                'type' => 'text',
                'group' => 'stats',
                'description' => 'Label for movies statistic',
                'is_public' => true,
            ],
            [
                'key' => 'stats_songs_count',
                'value' => '2,000+',
                'type' => 'text',
                'group' => 'stats',
                'description' => 'Number of songs released',
                'is_public' => true,
            ],
            [
                'key' => 'stats_songs_label',
                'value' => 'Songs Released',
                'type' => 'text',
                'group' => 'stats',
                'description' => 'Label for songs statistic',
                'is_public' => true,
            ],
            [
                'key' => 'stats_films_count',
                'value' => '800+',
                'type' => 'text',
                'group' => 'stats',
                'description' => 'Number of short films',
                'is_public' => true,
            ],
            [
                'key' => 'stats_films_label',
                'value' => 'Short Films',
                'type' => 'text',
                'group' => 'stats',
                'description' => 'Label for short films statistic',
                'is_public' => true,
            ],
            [
                'key' => 'stats_views_count',
                'value' => '50M+',
                'type' => 'text',
                'group' => 'stats',
                'description' => 'Total number of views',
                'is_public' => true,
            ],
            [
                'key' => 'stats_views_label',
                'value' => 'Total Views',
                'type' => 'text',
                'group' => 'stats',
                'description' => 'Label for total views statistic',
                'is_public' => true,
            ],
            [
                'key' => 'stats_section_title',
                'value' => 'Our',
                'type' => 'text',
                'group' => 'stats',
                'description' => 'Stats section main title',
                'is_public' => true,
            ],
            [
                'key' => 'stats_section_highlighted_title',
                'value' => 'Impact',
                'type' => 'text',
                'group' => 'stats',
                'description' => 'Stats section highlighted title',
                'is_public' => true,
            ],
            [
                'key' => 'stats_section_description',
                'value' => 'Numbers that speak to our commitment to bringing quality content to global audiences',
                'type' => 'textarea',
                'group' => 'stats',
                'description' => 'Stats section description',
                'is_public' => true,
            ],

            // Call to Action Settings
            [
                'key' => 'cta_badge_text',
                'value' => 'Let\'s Create Together',
                'type' => 'text',
                'group' => 'cta',
                'description' => 'CTA section badge text',
                'is_public' => true,
            ],
            [
                'key' => 'cta_main_title',
                'value' => 'Ready to Share Your',
                'type' => 'text',
                'group' => 'cta',
                'description' => 'CTA section main title',
                'is_public' => true,
            ],
            [
                'key' => 'cta_highlighted_title',
                'value' => 'Story?',
                'type' => 'text',
                'group' => 'cta',
                'description' => 'CTA section highlighted title',
                'is_public' => true,
            ],
            [
                'key' => 'cta_description',
                'value' => 'Join our network of visionary creators and studios. Let\'s bring your exceptional content to audiences worldwide through strategic digital distribution.',
                'type' => 'textarea',
                'group' => 'cta',
                'description' => 'CTA section description',
                'is_public' => true,
            ],
            [
                'key' => 'cta_primary_button_text',
                'value' => 'Start Partnership',
                'type' => 'text',
                'group' => 'cta',
                'description' => 'CTA primary button text',
                'is_public' => true,
            ],
            [
                'key' => 'cta_secondary_button_text',
                'value' => 'View Our Work',
                'type' => 'text',
                'group' => 'cta',
                'description' => 'CTA secondary button text',
                'is_public' => true,
            ],

            // CTA Features
            [
                'key' => 'cta_feature_1_title',
                'value' => 'Fast Partnership',
                'type' => 'text',
                'group' => 'cta',
                'description' => 'First CTA feature title',
                'is_public' => true,
            ],
            [
                'key' => 'cta_feature_1_description',
                'value' => 'Quick approval process for quality content creators and studios.',
                'type' => 'text',
                'group' => 'cta',
                'description' => 'First CTA feature description',
                'is_public' => true,
            ],
            [
                'key' => 'cta_feature_2_title',
                'value' => 'Global Reach',
                'type' => 'text',
                'group' => 'cta',
                'description' => 'Second CTA feature title',
                'is_public' => true,
            ],
            [
                'key' => 'cta_feature_2_description',
                'value' => 'Access to worldwide audiences through strategic distribution.',
                'type' => 'text',
                'group' => 'cta',
                'description' => 'Second CTA feature description',
                'is_public' => true,
            ],
            [
                'key' => 'cta_feature_3_title',
                'value' => 'Fair Revenue',
                'type' => 'text',
                'group' => 'cta',
                'description' => 'Third CTA feature title',
                'is_public' => true,
            ],
            [
                'key' => 'cta_feature_3_description',
                'value' => 'Transparent revenue sharing with competitive rates for creators.',
                'type' => 'text',
                'group' => 'cta',
                'description' => 'Third CTA feature description',
                'is_public' => true,
            ],

            // Branding Settings
            [
                'key' => 'brand_primary_color',
                'value' => '#ec681b',
                'type' => 'color',
                'group' => 'branding',
                'description' => 'Primary brand color',
                'is_public' => true,
            ],
            [
                'key' => 'company_name',
                'value' => 'OSR Digital',
                'type' => 'text',
                'group' => 'branding',
                'description' => 'Company name',
                'is_public' => true,
            ],

            // Contact Information
            [
                'key' => 'contact_email',
                'value' => 'info@osrdigital.com',
                'type' => 'email',
                'group' => 'contact',
                'description' => 'Main contact email',
                'is_public' => true,
            ],
            [
                'key' => 'contact_phone',
                'value' => '+1 (555) 123-4567',
                'type' => 'text',
                'group' => 'contact',
                'description' => 'Main contact phone',
                'is_public' => true,
            ],

            // Legacy logo settings
            [
                'key' => 'site_title',
                'value' => 'OSR Digital - Global Entertainment Distribution',
                'type' => 'text',
                'group' => 'seo',
                'description' => 'Website title for SEO',
                'is_public' => true,
            ],
            [
                'key' => 'site_description',
                'value' => 'OSR Digital specializes in acquiring exceptional entertainment content and strategically distributing it to worldwide audiences through cutting-edge digital platforms.',
                'type' => 'textarea',
                'group' => 'seo',
                'description' => 'Website meta description',
                'is_public' => true,
            ],
            [
                'key' => 'logo_light',
                'value' => null,
                'type' => 'text',
                'group' => 'branding',
                'description' => 'Light theme logo',
                'is_public' => true,
            ],
            [
                'key' => 'logo_dark',
                'value' => null,
                'type' => 'text',
                'group' => 'branding',
                'description' => 'Dark theme logo',
                'is_public' => true,
            ],
            [
                'key' => 'logo_admin',
                'value' => null,
                'type' => 'text',
                'group' => 'branding',
                'description' => 'Admin panel logo',
                'is_public' => true,
            ],
            [
                'key' => 'logo_mobile',
                'value' => null,
                'type' => 'text',
                'group' => 'branding',
                'description' => 'Mobile logo',
                'is_public' => true,
            ],
            [
                'key' => 'logo_footer',
                'value' => null,
                'type' => 'text',
                'group' => 'branding',
                'description' => 'Footer logo',
                'is_public' => true,
            ],
            [
                'key' => 'logo_email',
                'value' => null,
                'type' => 'text',
                'group' => 'branding',
                'description' => 'Email template logo',
                'is_public' => true,
            ],
            [
                'key' => 'favicon',
                'value' => null,
                'type' => 'text',
                'group' => 'branding',
                'description' => 'Website favicon',
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
