<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DynamicPage;
use App\Models\ContentBlock;

class DynamicPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create content blocks first
        $this->createContentBlocks();
        
        // Create dynamic pages
        $this->createDynamicPages();
    }

    private function createContentBlocks()
    {
        $blocks = [
            // Homepage blocks
            [
                'type' => 'hero',
                'name' => 'Homepage Hero',
                'data' => [
                    'title' => 'Welcome to OSR Digital',
                    'subtitle' => 'Leading digital content distribution company',
                    'description' => 'We help creators and businesses distribute their content across multiple platforms and reach global audiences.',
                    'primaryButton' => ['text' => 'Get Started', 'url' => '/contact'],
                    'secondaryButton' => ['text' => 'Learn More', 'url' => '/about'],
                    'backgroundImage' => null,
                    'height' => 'full',
                    'alignment' => 'center'
                ],
                'settings' => [],
                'category' => 'homepage',
                'is_reusable' => true,
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'type' => 'stats',
                'name' => 'Homepage Stats',
                'data' => [
                    'title' => 'Our Impact',
                    'subtitle' => 'Numbers that speak for themselves',
                    'stats' => [
                        ['number' => '500+', 'label' => 'Movies Published'],
                        ['number' => '2,000+', 'label' => 'Songs Released'],
                        ['number' => '800+', 'label' => 'Short Films'],
                        ['number' => '50M+', 'label' => 'Total Views']
                    ],
                    'columns' => 4,
                    'backgroundColor' => 'primary'
                ],
                'settings' => [],
                'category' => 'homepage',
                'is_reusable' => true,
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'type' => 'features',
                'name' => 'Homepage Features',
                'data' => [
                    'title' => 'What We Do',
                    'subtitle' => 'Comprehensive digital content solutions',
                    'features' => [
                        [
                            'icon' => '🎬',
                            'title' => 'Content Distribution',
                            'description' => 'Distribute your content across multiple platforms worldwide'
                        ],
                        [
                            'icon' => '📱',
                            'title' => 'Mobile Optimization',
                            'description' => 'Optimized for all mobile devices and screen sizes'
                        ],
                        [
                            'icon' => '🌍',
                            'title' => 'Global Reach',
                            'description' => 'Reach audiences in over 100 countries worldwide'
                        ]
                    ],
                    'columns' => 3
                ],
                'settings' => [],
                'category' => 'homepage',
                'is_reusable' => true,
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'type' => 'cta',
                'name' => 'Homepage CTA',
                'data' => [
                    'title' => 'Ready to Get Started?',
                    'description' => 'Join thousands of creators who trust OSR Digital for their content distribution needs.',
                    'primaryButton' => ['text' => 'Start Your Journey', 'url' => '/contact'],
                    'secondaryButton' => ['text' => 'View Portfolio', 'url' => '/portfolio'],
                    'backgroundColor' => 'accent'
                ],
                'settings' => [],
                'category' => 'homepage',
                'is_reusable' => true,
                'is_active' => true,
                'sort_order' => 4
            ],
            // About page blocks
            [
                'type' => 'hero',
                'name' => 'About Hero',
                'data' => [
                    'title' => 'About OSR Digital',
                    'subtitle' => 'Your trusted partner in digital content distribution',
                    'description' => 'We are passionate about helping creators and businesses reach their full potential through innovative digital solutions.',
                    'height' => 'large',
                    'alignment' => 'center'
                ],
                'settings' => [],
                'category' => 'about',
                'is_reusable' => true,
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'type' => 'text',
                'name' => 'About Story',
                'data' => [
                    'title' => 'Our Story',
                    'content' => '<p>Founded in 2020, OSR Digital has been at the forefront of digital content distribution. We started with a simple mission: to make content distribution accessible to everyone, regardless of their size or budget.</p><p>Today, we serve thousands of creators and businesses worldwide, helping them reach millions of viewers across multiple platforms. Our team of experts is dedicated to providing innovative solutions that drive real results.</p>',
                    'alignment' => 'left',
                    'maxWidth' => '4xl'
                ],
                'settings' => [],
                'category' => 'about',
                'is_reusable' => true,
                'is_active' => true,
                'sort_order' => 2
            ],
            // Contact page blocks
            [
                'type' => 'hero',
                'name' => 'Contact Hero',
                'data' => [
                    'title' => 'Get In Touch',
                    'subtitle' => 'We\'d love to hear from you',
                    'description' => 'Ready to start your digital content journey? Contact us today and let\'s discuss how we can help you reach your goals.',
                    'height' => 'large',
                    'alignment' => 'center'
                ],
                'settings' => [],
                'category' => 'contact',
                'is_reusable' => true,
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'type' => 'contact',
                'name' => 'Contact Form',
                'data' => [
                    'title' => 'Send us a Message',
                    'subtitle' => 'Fill out the form below and we\'ll get back to you within 24 hours'
                ],
                'settings' => [],
                'category' => 'contact',
                'is_reusable' => true,
                'is_active' => true,
                'sort_order' => 2
            ]
        ];

        foreach ($blocks as $blockData) {
            ContentBlock::create($blockData);
        }
    }

    private function createDynamicPages()
    {
        $pages = [
            [
                'slug' => 'home',
                'title' => 'Home - OSR Digital',
                'meta_title' => 'OSR Digital - Leading Digital Content Distribution',
                'meta_description' => 'Leading digital content distribution company helping creators and businesses reach global audiences across multiple platforms.',
                'template' => 'landing',
                'content_blocks' => [
                    ['id' => 1], // Homepage Hero
                    ['id' => 2], // Homepage Stats
                    ['id' => 3], // Homepage Features
                    ['id' => 4]  // Homepage CTA
                ],
                'settings' => [
                    'show_header' => true,
                    'show_footer' => true,
                    'page_width' => 'full'
                ],
                'is_published' => true,
                'is_homepage' => true,
                'sort_order' => 1
            ],
            [
                'slug' => 'about',
                'title' => 'About Us - OSR Digital',
                'meta_title' => 'About OSR Digital - Your Digital Content Partner',
                'meta_description' => 'Learn about OSR Digital\'s mission to make content distribution accessible to everyone. Discover our story, values, and commitment to creators.',
                'template' => 'about',
                'content_blocks' => [
                    ['id' => 5], // About Hero
                    ['id' => 6]  // About Story
                ],
                'settings' => [
                    'show_header' => true,
                    'show_footer' => true,
                    'page_width' => 'full'
                ],
                'is_published' => true,
                'is_homepage' => false,
                'sort_order' => 2
            ],
            [
                'slug' => 'contact',
                'title' => 'Contact Us - OSR Digital',
                'meta_title' => 'Contact OSR Digital - Get In Touch Today',
                'meta_description' => 'Ready to start your digital content journey? Contact OSR Digital today and let\'s discuss how we can help you reach your goals.',
                'template' => 'contact',
                'content_blocks' => [
                    ['id' => 7], // Contact Hero
                    ['id' => 8]  // Contact Form
                ],
                'settings' => [
                    'show_header' => true,
                    'show_footer' => true,
                    'page_width' => 'full'
                ],
                'is_published' => true,
                'is_homepage' => false,
                'sort_order' => 3
            ],
            [
                'slug' => 'business',
                'title' => 'Business - OSR Digital',
                'meta_title' => 'Business Solutions - OSR Digital',
                'meta_description' => 'Discover our comprehensive business solutions for digital content distribution and management.',
                'template' => 'business',
                'content_blocks' => [
                    ['id' => 1], // Hero (reuse)
                    ['id' => 3]  // Features (reuse)
                ],
                'settings' => [
                    'show_header' => true,
                    'show_footer' => true,
                    'page_width' => 'full'
                ],
                'is_published' => true,
                'is_homepage' => false,
                'sort_order' => 4
            ],
            [
                'slug' => 'portfolio',
                'title' => 'Portfolio - OSR Digital',
                'meta_title' => 'Our Portfolio - OSR Digital',
                'meta_description' => 'Explore our portfolio of successful digital content distribution projects and client work.',
                'template' => 'portfolio',
                'content_blocks' => [
                    ['id' => 1], // Hero (reuse)
                    ['id' => 2]  // Stats (reuse)
                ],
                'settings' => [
                    'show_header' => true,
                    'show_footer' => true,
                    'page_width' => 'full'
                ],
                'is_published' => true,
                'is_homepage' => false,
                'sort_order' => 5
            ],
            [
                'slug' => 'partners',
                'title' => 'Partners - OSR Digital',
                'meta_title' => 'Our Partners - OSR Digital',
                'meta_description' => 'Meet our trusted partners who help us deliver exceptional digital content distribution services.',
                'template' => 'partners',
                'content_blocks' => [
                    ['id' => 1], // Hero (reuse)
                    ['id' => 3]  // Features (reuse)
                ],
                'settings' => [
                    'show_header' => true,
                    'show_footer' => true,
                    'page_width' => 'full'
                ],
                'is_published' => true,
                'is_homepage' => false,
                'sort_order' => 6
            ],
            [
                'slug' => 'team',
                'title' => 'Team - OSR Digital',
                'meta_title' => 'Our Team - OSR Digital',
                'meta_description' => 'Meet the talented team behind OSR Digital\'s success in digital content distribution.',
                'template' => 'team',
                'content_blocks' => [
                    ['id' => 5], // About Hero (reuse)
                    ['id' => 6]  // About Story (reuse)
                ],
                'settings' => [
                    'show_header' => true,
                    'show_footer' => true,
                    'page_width' => 'full'
                ],
                'is_published' => true,
                'is_homepage' => false,
                'sort_order' => 7
            ]
        ];

        foreach ($pages as $pageData) {
            DynamicPage::updateOrCreate(
                ['slug' => $pageData['slug']], // Find by slug
                $pageData // Update or create with these values
            );
        }
    }
}
