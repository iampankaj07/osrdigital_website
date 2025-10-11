<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Content Acquisition',
                'description' => 'Strategic identification and acquisition of exceptional movies, music, and short films from creators worldwide.',
                'short_description' => 'Strategic content identification and acquisition',
                'icon' => 'fas fa-bullseye',
                'sort_order' => 1,
                'is_featured' => true,
                'is_active' => true,
                'slug' => 'content-acquisition',
            ],
            [
                'title' => 'YouTube Publishing',
                'description' => 'Expert execution of strategic YouTube publishing campaigns to maximize reach and engagement.',
                'short_description' => 'Strategic YouTube publishing campaigns',
                'icon' => 'fas fa-play-circle',
                'sort_order' => 2,
                'is_featured' => true,
                'is_active' => true,
                'slug' => 'youtube-publishing',
            ],
            [
                'title' => 'Global Distribution',
                'description' => 'Worldwide content distribution across multiple platforms and cultural markets.',
                'short_description' => 'Worldwide content distribution',
                'icon' => 'fas fa-globe',
                'sort_order' => 3,
                'is_featured' => true,
                'is_active' => true,
                'slug' => 'global-distribution',
            ],
            [
                'title' => 'Creator Support',
                'description' => 'Comprehensive support for content creators throughout the entire distribution process.',
                'short_description' => 'Comprehensive creator support',
                'icon' => 'fas fa-palette',
                'sort_order' => 4,
                'is_featured' => true,
                'is_active' => true,
                'slug' => 'creator-support',
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['slug' => $service['slug']], // Find by slug
                $service // Update or create with these values
            );
        }
    }
}