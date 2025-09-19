<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class PartnerSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partnerSettings = [
            // Page header settings
            [
                'key' => 'partners_badge',
                'value' => 'Global Network',
                'type' => 'text',
                'group' => 'partners',
                'description' => 'Badge text for partners page header',
                'is_public' => true,
            ],
            [
                'key' => 'partners_title',
                'value' => 'Strategic Content Partnership Network',
                'type' => 'text',
                'group' => 'partners',
                'description' => 'Main title for partners page',
                'is_public' => true,
            ],
            [
                'key' => 'partners_description',
                'value' => 'Building bridges between content creators and global audiences through strategic partnerships. We collaborate with studios, independent creators, distributors, and technology innovators to maximize content reach, engagement, and revenue potential across all digital platforms.',
                'type' => 'text',
                'group' => 'partners',
                'description' => 'Description for partners page header',
                'is_public' => true,
            ],

            // Partnership categories section
            [
                'key' => 'partnership_categories_title',
                'value' => 'Partnership Ecosystem',
                'type' => 'text',
                'group' => 'partners',
                'description' => 'Title for partnership categories section',
                'is_public' => true,
            ],
            [
                'key' => 'partnership_categories_subtitle',
                'value' => 'Our diverse network spans the entire content lifecycle, from creation to distribution. We connect visionary creators with the resources, technology, and platforms they need to succeed in the global digital marketplace.',
                'type' => 'text',
                'group' => 'partners',
                'description' => 'Subtitle for partnership categories section',
                'is_public' => true,
            ],

            // Partnership Categories as Repeater
            [
                'key' => 'partnership_categories_items',
                'value' => json_encode([
                    [
                        'title' => 'Production Studios',
                        'description' => 'Professional production studios creating high-quality films, series, documentaries, and digital content for global distribution.',
                        'count_display' => '35+',
                        'icon' => '🎬',
                        'image' => null,
                    ],
                    [
                        'title' => 'Content Creators',
                        'description' => 'Independent filmmakers, YouTubers, musicians, podcasters, and digital artists building audiences worldwide.',
                        'count_display' => '250+',
                        'icon' => '🎨',
                        'image' => null,
                    ],
                    [
                        'title' => 'Distribution Networks',
                        'description' => 'Strategic distribution partners connecting content with audiences across television, streaming, and digital platforms globally.',
                        'count_display' => '60+',
                        'icon' => '🌍',
                        'image' => null,
                    ],
                    [
                        'title' => 'Streaming Platforms',
                        'description' => 'Digital platforms, OTT services, and streaming networks amplifying content reach across multiple territories and demographics.',
                        'count_display' => '45+',
                        'icon' => '📺',
                        'image' => null,
                    ],
                    [
                        'title' => 'Technology Partners',
                        'description' => 'Innovative technology companies providing advanced tools for content creation, distribution, analytics, and audience engagement.',
                        'count_display' => '28+',
                        'icon' => '⚡',
                        'image' => null,
                    ],
                    [
                        'title' => 'Music & Audio',
                        'description' => 'Record labels, music producers, podcast networks, and audio content specialists expanding their digital presence.',
                        'count_display' => '85+',
                        'icon' => '🎵',
                        'image' => null,
                    ],
                ]),
                'type' => 'json',
                'group' => 'partners',
                'description' => 'Partnership categories repeater data',
                'is_public' => true,
            ],

            // Associates section
            [
                'key' => 'associates_title',
                'value' => 'Trusted Associates & Service Partners',
                'type' => 'text',
                'group' => 'partners',
                'description' => 'Title for associates section',
                'is_public' => true,
            ],
            [
                'key' => 'associates_items',
                'value' => json_encode([
                    [
                        'name' => 'MediaTech Solutions',
                        'description' => 'Advanced video encoding, streaming infrastructure, and content delivery network solutions for global media companies.',
                        'category' => 'Technology',
                        'website' => 'https://mediatech-solutions.com',
                        'logo' => '/images/associates/mediatech-logo.png',
                    ],
                    [
                        'name' => 'Independent Creators Alliance',
                        'description' => 'A collective of award-winning independent filmmakers, YouTubers, and digital content creators pushing creative boundaries.',
                        'category' => 'Creative',
                        'website' => 'https://independentcreators.org',
                        'logo' => '/images/associates/ica-logo.png',
                    ],
                    [
                        'name' => 'Global Content Distribution',
                        'description' => 'Premier international distribution network specializing in multi-platform content delivery across 180+ countries.',
                        'category' => 'Distribution',
                        'website' => 'https://globalcontentdist.com',
                        'logo' => '/images/associates/gcd-logo.png',
                    ],
                    [
                        'name' => 'StreamFlow Analytics',
                        'description' => 'Real-time audience analytics, performance tracking, and revenue optimization tools for content creators and distributors.',
                        'category' => 'Analytics',
                        'website' => 'https://streamflow-analytics.com',
                        'logo' => '/images/associates/streamflow-logo.png',
                    ],
                    [
                        'name' => 'Indie Film Hub',
                        'description' => 'Supporting emerging filmmakers with funding, distribution, and marketing resources for independent cinema projects.',
                        'category' => 'Production',
                        'website' => 'https://indiefilmhub.io',
                        'logo' => '/images/associates/ifh-logo.png',
                    ],
                    [
                        'name' => 'Digital Music Collective',
                        'description' => 'Empowering independent musicians and labels with distribution, promotion, and monetization across digital platforms.',
                        'category' => 'Music',
                        'website' => 'https://digitalmusiccollective.com',
                        'logo' => '/images/associates/dmc-logo.png',
                    ],
                    [
                        'name' => 'Content Rights Management',
                        'description' => 'Comprehensive rights management, licensing, and legal services for intellectual property protection and monetization.',
                        'category' => 'Legal Services',
                        'website' => 'https://contentrights.legal',
                        'logo' => '/images/associates/crm-logo.png',
                    ],
                    [
                        'name' => 'Next-Gen Streaming',
                        'description' => 'Cutting-edge streaming platform development, white-label solutions, and custom OTT platform services.',
                        'category' => 'Technology',
                        'website' => 'https://nextgenstreaming.tech',
                        'logo' => '/images/associates/ngs-logo.png',
                    ],
                    [
                        'name' => 'Audience Growth Labs',
                        'description' => 'Data-driven marketing and audience development strategies for content creators and entertainment brands.',
                        'category' => 'Marketing',
                        'website' => 'https://audiencegrowthlabs.com',
                        'logo' => '/images/associates/agl-logo.png',
                    ],
                    [
                        'name' => 'Documentary Collective',
                        'description' => 'Non-profit organization supporting documentary filmmakers with funding, distribution, and impact campaign resources.',
                        'category' => 'Documentary',
                        'website' => 'https://documentarycollective.org',
                        'logo' => '/images/associates/dc-logo.png',
                    ],
                    [
                        'name' => 'Podcast Network Pro',
                        'description' => 'Professional podcast production, distribution, and monetization services for creators and enterprise clients.',
                        'category' => 'Audio',
                        'website' => 'https://podcastnetworkpro.com',
                        'logo' => '/images/associates/pnp-logo.png',
                    ],
                    [
                        'name' => 'Virtual Production Studios',
                        'description' => 'State-of-the-art virtual production facilities using LED walls, motion capture, and real-time rendering technology.',
                        'category' => 'Production',
                        'website' => 'https://virtualproductionstudios.com',
                        'logo' => '/images/associates/vps-logo.png',
                    ]
                ]),
                'type' => 'json',
                'group' => 'partners',
                'description' => 'Associates items as repeater data',
                'is_public' => true,
            ],
        ];

        foreach ($partnerSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        // Clear cache after seeding
        Setting::clearCache();
    }
}
