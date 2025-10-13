<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BusinessPage;

class BusinessPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BusinessPage::create([
            'title' => 'Business Solutions',
            'subtitle' => 'Professional Digital Distribution Services',
            'description' => 'We provide comprehensive digital distribution solutions for content creators, filmmakers, and media companies. Our platform helps you reach global audiences through strategic distribution across multiple digital channels.',
            'meta_title' => 'Business Solutions - OSR Digital',
            'meta_description' => 'Professional digital distribution services for content creators. Reach global audiences with our comprehensive distribution platform.',
            'hero_image' => null,
            'hero_video' => null,
            'content_sections' => [
                [
                    'id' => '1',
                    'type' => 'text',
                    'title' => 'Global Distribution Network',
                    'content' => 'Our extensive network of distribution partners ensures your content reaches audiences worldwide. We work with major streaming platforms, digital marketplaces, and international distributors to maximize your content\'s visibility and revenue potential.',
                    'image' => null,
                ],
                [
                    'id' => '2',
                    'type' => 'text',
                    'title' => 'Content Strategy & Optimization',
                    'content' => 'Our team of experts works closely with you to develop customized distribution strategies. We analyze market trends, audience preferences, and platform requirements to optimize your content for maximum impact and engagement.',
                    'image' => null,
                ],
                [
                    'id' => '3',
                    'type' => 'text',
                    'title' => 'Revenue Maximization',
                    'content' => 'Through strategic pricing, targeted marketing, and optimal release timing, we help maximize your content\'s revenue potential. Our data-driven approach ensures you get the best return on your investment.',
                    'image' => null,
                ],
            ],
            'features' => [
                [
                    'id' => '1',
                    'title' => 'Multi-Platform Distribution',
                    'description' => 'Distribute your content across 100+ platforms worldwide including Netflix, Amazon Prime, Hulu, and more.',
                    'icon' => 'fas fa-globe',
                    'image' => null,
                ],
                [
                    'id' => '2',
                    'title' => 'Content Management',
                    'description' => 'Complete content lifecycle management from encoding to delivery with quality assurance at every step.',
                    'icon' => 'fas fa-cogs',
                    'image' => null,
                ],
                [
                    'id' => '3',
                    'title' => 'Analytics & Reporting',
                    'description' => 'Comprehensive analytics and real-time reporting to track performance and revenue across all platforms.',
                    'icon' => 'fas fa-chart-line',
                    'image' => null,
                ],
                [
                    'id' => '4',
                    'title' => 'Rights Management',
                    'description' => 'Secure rights management and protection with advanced DRM and geo-blocking capabilities.',
                    'icon' => 'fas fa-shield-alt',
                    'image' => null,
                ],
                [
                    'id' => '5',
                    'title' => 'Marketing Support',
                    'description' => 'Dedicated marketing support including promotional campaigns and audience targeting strategies.',
                    'icon' => 'fas fa-bullhorn',
                    'image' => null,
                ],
                [
                    'id' => '6',
                    'title' => '24/7 Support',
                    'description' => 'Round-the-clock technical and customer support to ensure smooth operations and quick issue resolution.',
                    'icon' => 'fas fa-headset',
                    'image' => null,
                ],
            ],
            'statistics' => [
                [
                    'id' => '1',
                    'label' => 'Distribution Partners',
                    'value' => '100',
                    'suffix' => '+',
                    'icon' => 'fas fa-handshake',
                ],
                [
                    'id' => '2',
                    'label' => 'Content Titles Distributed',
                    'value' => '10,000',
                    'suffix' => '+',
                    'icon' => 'fas fa-film',
                ],
                [
                    'id' => '3',
                    'label' => 'Global Reach',
                    'value' => '150',
                    'suffix' => ' Countries',
                    'icon' => 'fas fa-globe-americas',
                ],
                [
                    'id' => '4',
                    'label' => 'Client Satisfaction',
                    'value' => '98',
                    'suffix' => '%',
                    'icon' => 'fas fa-star',
                ],
            ],
            'call_to_action' => [
                'text' => 'Get Started Today',
                'url' => '/contact',
            ],
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }
}
