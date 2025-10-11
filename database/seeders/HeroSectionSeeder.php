<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HeroSection;

class HeroSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $heroSections = [
            [
                'page' => 'home',
                'title' => 'Bringing Stories to Global Screens',
                'subtitle' => 'Strategic content acquisition and YouTube publishing for worldwide audiences',
                'content' => 'OSR Digital is a leading content acquisition and distribution company specializing in bringing exceptional entertainment to global audiences through strategic YouTube publishing and innovative media solutions.',
                'button_text' => 'Get Started',
                'button_link' => '/contact',
                'button_text_secondary' => 'Learn More',
                'button_link_secondary' => '/about',
                'is_active' => true,
                'sort_order' => 0
            ],
            [
                'page' => 'about',
                'title' => 'We Bring Stories to Global Screens',
                'subtitle' => 'About OSR Digital',
                'content' => 'OSR Digital is a leading content acquisition and distribution company specializing in bringing exceptional entertainment to global audiences through strategic YouTube publishing and innovative media solutions.',
                'button_text' => 'Partner With Us',
                'button_link' => '/contact',
                'button_text_secondary' => 'Meet Our Team',
                'button_link_secondary' => '/team',
                'is_active' => true,
                'sort_order' => 0
            ],
            [
                'page' => 'partners',
                'title' => 'Strategic Partnerships for Global Success',
                'subtitle' => 'Our Partners',
                'content' => 'We work with leading platforms, studios, and creators worldwide to bring exceptional content to global audiences through innovative distribution strategies.',
                'button_text' => 'Become a Partner',
                'button_link' => '/contact',
                'button_text_secondary' => 'View Our Work',
                'button_link_secondary' => '/portfolio',
                'is_active' => true,
                'sort_order' => 0
            ],
            [
                'page' => 'team',
                'title' => 'Meet the Dream Team',
                'subtitle' => 'Our Team',
                'content' => 'The passionate professionals behind OSR Digital, dedicated to bringing exceptional content to global audiences through innovative distribution strategies.',
                'button_text' => 'Join Our Team',
                'button_link' => '/contact',
                'button_text_secondary' => 'Learn About Us',
                'button_link_secondary' => '/about',
                'is_active' => true,
                'sort_order' => 0
            ],
            [
                'page' => 'news',
                'title' => 'Stay Informed',
                'subtitle' => 'News & Updates',
                'content' => 'Discover the latest news, industry insights, and company updates from OSR Digital. Stay ahead of trends in digital content distribution.',
                'button_text' => 'Get Updates',
                'button_link' => '/contact',
                'button_text_secondary' => 'Learn More',
                'button_link_secondary' => '/about',
                'is_active' => true,
                'sort_order' => 0
            ]
        ];

        foreach ($heroSections as $heroSection) {
            HeroSection::create($heroSection);
        }
    }
}