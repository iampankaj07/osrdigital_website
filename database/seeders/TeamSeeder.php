<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            [
                'name' => 'John Smith',
                'position' => 'CEO & Founder',
                'description' => 'Visionary leader with over 15 years of experience in digital transformation and business strategy.',
                'email' => 'john@osrdigital.com',
                'phone' => '+1-555-0101',
                'social_links' => [
                    ['platform' => 'linkedin', 'url' => 'https://linkedin.com/in/johnsmith'],
                    ['platform' => 'twitter', 'url' => 'https://twitter.com/johnsmith'],
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Sarah Johnson',
                'position' => 'CTO',
                'description' => 'Technical expert specializing in full-stack development and system architecture.',
                'email' => 'sarah@osrdigital.com',
                'phone' => '+1-555-0102',
                'social_links' => [
                    ['platform' => 'linkedin', 'url' => 'https://linkedin.com/in/sarahjohnson'],
                    ['platform' => 'github', 'url' => 'https://github.com/sarahjohnson'],
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Mike Davis',
                'position' => 'Lead Developer',
                'description' => 'Passionate developer with expertise in Laravel, Vue.js, and modern web technologies.',
                'email' => 'mike@osrdigital.com',
                'phone' => '+1-555-0103',
                'social_links' => [
                    ['platform' => 'github', 'url' => 'https://github.com/mikedavis'],
                    ['platform' => 'website', 'url' => 'https://mikedavis.dev'],
                ],
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Emma Wilson',
                'position' => 'UI/UX Designer',
                'description' => 'Creative designer focused on user experience and modern interface design.',
                'email' => 'emma@osrdigital.com',
                'phone' => '+1-555-0104',
                'social_links' => [
                    ['platform' => 'linkedin', 'url' => 'https://linkedin.com/in/emmawilson'],
                    ['platform' => 'instagram', 'url' => 'https://instagram.com/emmawilson_design'],
                ],
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'David Brown',
                'position' => 'Project Manager',
                'description' => 'Experienced project manager ensuring smooth delivery of digital solutions.',
                'email' => 'david@osrdigital.com',
                'phone' => '+1-555-0105',
                'social_links' => [
                    ['platform' => 'linkedin', 'url' => 'https://linkedin.com/in/davidbrown'],
                ],
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($teams as $team) {
            \App\Models\Team::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($team['name'])],
                $team
            );
        }
    }
}
