<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class BusinessSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $businessSettings = [
            // Page header settings
            [
                'key' => 'business_page_title',
                'value' => 'Our Business Model',
                'type' => 'text',
                'group' => 'business',
                'description' => 'Main title for business page',
                'is_public' => true,
            ],
            [
                'key' => 'business_page_description',
                'value' => 'OSR Digital operates at the intersection of content creation and digital distribution, providing comprehensive solutions for content monetization and audience growth.',
                'type' => 'text',
                'group' => 'business',
                'description' => 'Description for business page header',
                'is_public' => true,
            ],

            // What We Do section
            [
                'key' => 'business_what_we_do_title',
                'value' => 'What We Do',
                'type' => 'text',
                'group' => 'business',
                'description' => 'Title for What We Do section',
                'is_public' => true,
            ],
            [
                'key' => 'business_what_we_do_subtitle',
                'value' => 'Our comprehensive suite of services covers every aspect of digital content distribution',
                'type' => 'text',
                'group' => 'business',
                'description' => 'Subtitle for What We Do section',
                'is_public' => true,
            ],
            [
                'key' => 'business_what_we_do_items',
                'value' => json_encode([
                    [
                        'icon' => '🎬',
                        'title' => 'Rights Acquisition',
                        'description' => 'We identify and acquire distribution rights to exceptional movies, music, and short films from creators worldwide, ensuring fair compensation and global reach.'
                    ],
                    [
                        'icon' => '📺',
                        'title' => 'YouTube Publishing',
                        'description' => 'Strategic publishing on YouTube with optimized metadata, thumbnails, and scheduling to maximize viewership and engagement across different time zones and audiences.'
                    ],
                    [
                        'icon' => '📊',
                        'title' => 'Analytics & Optimization',
                        'description' => 'Comprehensive analytics tracking and performance optimization to ensure maximum revenue generation and audience growth for all distributed content.'
                    ],
                    [
                        'icon' => '🎵',
                        'title' => 'Music Distribution',
                        'description' => 'Specialized music publishing services including playlist placement, social media promotion, and cross-platform distribution strategies.'
                    ],
                    [
                        'icon' => '🤝',
                        'title' => 'Creator Partnerships',
                        'description' => 'Long-term partnerships with content creators, providing ongoing support, marketing assistance, and revenue optimization strategies.'
                    ],
                    [
                        'icon' => '🌍',
                        'title' => 'Global Reach',
                        'description' => 'Leveraging our network and expertise to distribute content to global audiences, breaking geographical barriers and cultural boundaries.'
                    ]
                ]),
                'type' => 'json',
                'group' => 'business',
                'description' => 'What We Do items as JSON array',
                'is_public' => true,
            ],

            // Process section
            [
                'key' => 'business_process_title',
                'value' => 'Our Process',
                'type' => 'text',
                'group' => 'business',
                'description' => 'Title for Process section',
                'is_public' => true,
            ],
            [
                'key' => 'business_process_subtitle',
                'value' => 'From discovery to distribution, we handle every step of the content journey',
                'type' => 'text',
                'group' => 'business',
                'description' => 'Subtitle for Process section',
                'is_public' => true,
            ],
            [
                'key' => 'business_process_items',
                'value' => json_encode([
                    [
                        'step' => 1,
                        'title' => 'Content Discovery & Evaluation',
                        'description' => 'Our team actively scouts for exceptional content across various platforms and networks, evaluating potential based on quality, audience appeal, and market viability.'
                    ],
                    [
                        'step' => 2,
                        'title' => 'Rights Negotiation & Acquisition',
                        'description' => 'We work directly with creators, studios, and rights holders to negotiate fair and beneficial distribution agreements that protect creator interests while maximizing reach.'
                    ],
                    [
                        'step' => 3,
                        'title' => 'Content Optimization & Strategy',
                        'description' => 'Each piece of content undergoes strategic optimization including metadata enhancement, thumbnail design, and audience targeting to ensure maximum engagement.'
                    ],
                    [
                        'step' => 4,
                        'title' => 'Publication & Promotion',
                        'description' => 'Strategic publishing across our network of channels with coordinated promotional campaigns across social media platforms and industry networks.'
                    ],
                    [
                        'step' => 5,
                        'title' => 'Performance Monitoring & Revenue Sharing',
                        'description' => 'Continuous monitoring of performance metrics with transparent reporting and fair revenue sharing based on predetermined agreements.'
                    ]
                ]),
                'type' => 'json',
                'group' => 'business',
                'description' => 'Process items as JSON array',
                'is_public' => true,
            ],
        ];

        foreach ($businessSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        // Clear cache after seeding
        Setting::clearCache();
    }
}
