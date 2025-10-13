<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HeroSlider;

class HeroSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeroSlider::create([
            'title' => 'Premium Movie Distribution',
            'subtitle' => 'Movie Distribution',
            'description' => 'We acquire and distribute exceptional films to worldwide audiences through cutting-edge digital platforms and traditional distribution channels.',
            'button_text' => 'Get Started',
            'button_url' => '/contact',
            'button_text_secondary' => 'View Films',
            'button_url_secondary' => '/portfolio',
            'image' => null, // You can add image path later
            'sort_order' => 1,
            'is_active' => true,
        ]);

        HeroSlider::create([
            'title' => 'Global Film Network',
            'subtitle' => 'Worldwide Reach',
            'description' => 'Connect with audiences across continents through our extensive distribution network and strategic partnerships with leading platforms.',
            'button_text' => 'Learn More',
            'button_url' => '/about',
            'button_text_secondary' => 'Our Network',
            'button_url_secondary' => '/services',
            'image' => null, // You can add image path later
            'sort_order' => 2,
            'is_active' => true,
        ]);

        HeroSlider::create([
            'title' => 'Award-Winning Content',
            'subtitle' => 'Quality Films',
            'description' => 'Discover our collection of critically acclaimed and commercially successful films that captivate audiences worldwide.',
            'button_text' => 'View Portfolio',
            'button_url' => '/portfolio',
            'button_text_secondary' => 'Contact Us',
            'button_url_secondary' => '/contact',
            'image' => null, // You can add image path later
            'sort_order' => 3,
            'is_active' => true,
        ]);
    }
}
