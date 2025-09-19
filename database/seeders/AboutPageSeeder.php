<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Page::updateOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'About OSR Digital',
                'excerpt' => 'Leading the future of digital content distribution, connecting exceptional entertainment with global audiences through strategic YouTube publishing and innovative media solutions.',
                'content' => '<div class="prose max-w-none">
                    <h2>Our Story</h2>
                    <p>OSR Digital is a leading content acquisition and distribution company specializing in bringing exceptional entertainment to global audiences through strategic YouTube publishing.</p>

                    <h2>Our Mission</h2>
                    <p>To bridge the gap between content creators and global audiences by acquiring rights to exceptional movies, songs, and short films, and distributing them through strategic YouTube publishing. We believe in the power of storytelling to connect cultures and inspire communities worldwide.</p>

                    <h2>Our Vision</h2>
                    <p>To become the premier digital media company that brings diverse, high-quality entertainment content to screens worldwide, fostering cultural exchange and creative appreciation. We envision a world where great content knows no boundaries.</p>

                    <h2>What We Do</h2>
                    <h3>Content Acquisition</h3>
                    <p>We identify and acquire rights to exceptional movies, music, and short films from creators worldwide, building a diverse portfolio of premium content.</p>

                    <h3>Strategic Distribution</h3>
                    <p>Our expert team develops and executes strategic YouTube publishing campaigns to maximize reach, engagement, and revenue potential for every piece of content.</p>

                    <h3>Global Reach</h3>
                    <p>We connect content with audiences across different cultures and regions, creating opportunities for cross-cultural appreciation and global success.</p>
                </div>',
                'meta_title' => 'About OSR Digital - Leading Content Distribution Company',
                'meta_description' => 'Learn about OSR Digital, a leading content acquisition and distribution company specializing in bringing exceptional entertainment to global audiences through strategic YouTube publishing.',
                'featured_image' => null,
                'is_published' => true,
            ]
        );
    }
}
