<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DistributionService;

class DistributionServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Digital Streaming',
                'description' => 'Distribute your films across major streaming platforms including Netflix, Amazon Prime, Disney+, and more.',
                'icon_type' => 'svg',
                'icon_data' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2M9 12h6m-6 4h6" /></svg>',
                'link' => '/business',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Theatrical Release',
                'description' => 'Coordinate theatrical releases and cinema distribution across global markets with our extensive theater network.',
                'icon_type' => 'svg',
                'icon_data' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>',
                'link' => '/business',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Marketing Strategy',
                'description' => 'Comprehensive marketing campaigns including social media, press releases, and promotional materials.',
                'icon_type' => 'svg',
                'icon_data' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>',
                'link' => '/business',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Global Distribution',
                'description' => 'Worldwide distribution network ensuring your content reaches audiences in every major market.',
                'icon_type' => 'svg',
                'icon_data' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                'link' => '/business',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Content Acquisition',
                'description' => 'Strategic acquisition of premium content including films, documentaries, and series for distribution.',
                'icon_type' => 'svg',
                'icon_data' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                'link' => '/business',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'Rights Management',
                'description' => 'Complete rights management and licensing services for all distribution territories and platforms.',
                'icon_type' => 'svg',
                'icon_data' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>',
                'link' => '/business',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($services as $service) {
            DistributionService::create($service);
        }
    }
}
