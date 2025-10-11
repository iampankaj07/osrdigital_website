<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TeamValue;

class TeamValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            [
                'title' => 'Innovation',
                'description' => 'We constantly push boundaries and explore new technologies to stay ahead in the rapidly evolving digital landscape. Our team embraces change and seeks creative solutions to complex challenges.',
                'icon' => 'fas fa-lightbulb',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Collaboration',
                'description' => 'We believe in the power of teamwork and foster an environment where every voice is heard and valued. Our diverse team works together to achieve common goals and support each other\'s growth.',
                'icon' => 'fas fa-handshake',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Excellence',
                'description' => 'We strive for the highest standards in everything we do, from content curation to client service. Quality is at the heart of our operations and drives our commitment to delivering exceptional results.',
                'icon' => 'fas fa-chart-line',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Global Impact',
                'description' => 'We\'re committed to making content accessible worldwide and celebrating diverse voices and cultures. Our mission is to connect people across borders through the power of storytelling.',
                'icon' => 'fas fa-globe',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Integrity',
                'description' => 'We conduct business with honesty, transparency, and ethical practices. Trust is the foundation of our relationships with partners, clients, and team members.',
                'icon' => 'fas fa-shield-alt',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Growth Mindset',
                'description' => 'We embrace continuous learning and personal development. Every challenge is an opportunity to grow, and we encourage our team to pursue their passions and expand their skills.',
                'icon' => 'fas fa-rocket',
                'sort_order' => 6,
                'is_active' => true,
            ]
        ];

        foreach ($values as $value) {
            TeamValue::create($value);
        }
    }
}