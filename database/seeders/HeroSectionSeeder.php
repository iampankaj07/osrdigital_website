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
        $this->command->info('🎬 Creating Hero Sections...');

        $heroSections = [
            [
                'page' => 'home',
                'title' => 'Bringing Stories to Global Screens',
                'subtitle' => 'Strategic content acquisition and YouTube publishing for worldwide audiences',
                'content' => 'OSR Digital is a leading content acquisition and distribution company specializing in bringing exceptional entertainment to global audiences through strategic YouTube publishing and innovative media solutions. We help creators and studios maximize their reach and revenue through our comprehensive distribution network.',
                'button_text' => 'Get Started',
                'button_link' => '/contact',
                'button_text_secondary' => 'Learn More',
                'button_link_secondary' => '/about',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'page' => 'about',
                'title' => 'We Bring Stories to Global Screens',
                'subtitle' => 'About OSR Digital',
                'content' => 'OSR Digital is a leading content acquisition and distribution company specializing in bringing exceptional entertainment to global audiences through strategic YouTube publishing and innovative media solutions. Our mission is to connect exceptional content with worldwide audiences while maximizing creator success.',
                'button_text' => 'Partner With Us',
                'button_link' => '/contact',
                'button_text_secondary' => 'Meet Our Team',
                'button_link_secondary' => '/team',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'page' => 'partners',
                'title' => 'Strategic Partnerships for Global Success',
                'subtitle' => 'Our Partners',
                'content' => 'We work with leading platforms, studios, and creators worldwide to bring exceptional content to global audiences through innovative distribution strategies. Our partnerships span across multiple continents, ensuring maximum reach and impact for every piece of content we distribute.',
                'button_text' => 'Become a Partner',
                'button_link' => '/contact',
                'button_text_secondary' => 'View Our Work',
                'button_link_secondary' => '/portfolio',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'page' => 'team',
                'title' => 'Meet the Dream Team',
                'subtitle' => 'Our Team',
                'content' => 'The passionate professionals behind OSR Digital, dedicated to bringing exceptional content to global audiences through innovative distribution strategies. Our diverse team brings together expertise in content acquisition, digital marketing, and global distribution.',
                'button_text' => 'Join Our Team',
                'button_link' => '/contact',
                'button_text_secondary' => 'Learn About Us',
                'button_link_secondary' => '/about',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'page' => 'news',
                'title' => 'Stay Informed',
                'subtitle' => 'News & Updates',
                'content' => 'Discover the latest news, industry insights, and company updates from OSR Digital. Stay ahead of trends in digital content distribution and learn about our latest partnerships, achievements, and industry developments.',
                'button_text' => 'Get Updates',
                'button_link' => '/contact',
                'button_text_secondary' => 'Learn More',
                'button_link_secondary' => '/about',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'page' => 'portfolio',
                'title' => 'Our Portfolio',
                'subtitle' => 'Featured Content & Success Stories',
                'content' => 'Explore our diverse portfolio of successfully distributed content across multiple genres and platforms. From blockbuster films to indie documentaries, we\'ve helped creators reach global audiences and achieve unprecedented success.',
                'button_text' => 'View Portfolio',
                'button_link' => '/portfolio',
                'button_text_secondary' => 'Partner With Us',
                'button_link_secondary' => '/contact',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'page' => 'contact',
                'title' => 'Get In Touch',
                'subtitle' => 'Let\'s Start Your Global Distribution Journey',
                'content' => 'Ready to take your content global? Our team of distribution experts is here to help you maximize your reach and revenue. Contact us today to discuss your content distribution needs and discover how we can help you achieve your goals.',
                'button_text' => 'Start Partnership',
                'button_link' => '#contact-form',
                'button_text_secondary' => 'Learn More',
                'button_link_secondary' => '/about',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'page' => 'business',
                'title' => 'Business Solutions',
                'subtitle' => 'Comprehensive Content Distribution Services',
                'content' => 'We provide end-to-end content distribution solutions for businesses, studios, and independent creators. From content acquisition to global publishing, our services are designed to maximize your content\'s reach and revenue potential.',
                'button_text' => 'Explore Services',
                'button_link' => '/services',
                'button_text_secondary' => 'Get Started',
                'button_link_secondary' => '/contact',
                'is_active' => true,
                'sort_order' => 1
            ]
        ];

        foreach ($heroSections as $heroSection) {
            HeroSection::updateOrCreate(
                ['page' => $heroSection['page']], // Find by page
                $heroSection // Update or create with these values
            );
        }

        $this->command->info('✅ Hero sections created/updated successfully!');
        $this->command->info('📄 Pages: ' . implode(', ', array_column($heroSections, 'page')));
    }
}