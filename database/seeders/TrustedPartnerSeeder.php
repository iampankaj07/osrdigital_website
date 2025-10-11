<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrustedPartner;

class TrustedPartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            [
                'name' => 'YouTube',
                'description' => 'Global video sharing platform with over 2 billion logged-in users monthly',
                'logo' => 'https://via.placeholder.com/200x100/FF0000/FFFFFF?text=YouTube',
                'website_url' => 'https://youtube.com',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Vimeo',
                'description' => 'Professional video platform for creators and businesses',
                'logo' => 'https://via.placeholder.com/200x100/1AB7EA/FFFFFF?text=Vimeo',
                'website_url' => 'https://vimeo.com',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Netflix',
                'description' => 'Leading streaming entertainment service with 200+ million paid memberships',
                'logo' => 'https://via.placeholder.com/200x100/E50914/FFFFFF?text=Netflix',
                'website_url' => 'https://netflix.com',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Amazon Prime Video',
                'description' => 'Video streaming service included with Amazon Prime membership',
                'logo' => 'https://via.placeholder.com/200x100/00A8E1/FFFFFF?text=Prime',
                'website_url' => 'https://primevideo.com',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Disney+',
                'description' => 'Streaming service featuring Disney, Pixar, Marvel, Star Wars, and National Geographic content',
                'logo' => 'https://via.placeholder.com/200x100/113CCF/FFFFFF?text=Disney+',
                'website_url' => 'https://disneyplus.com',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'HBO Max',
                'description' => 'Streaming platform featuring HBO originals, Warner Bros. movies, and more',
                'logo' => 'https://via.placeholder.com/200x100/8B5CF6/FFFFFF?text=HBO+Max',
                'website_url' => 'https://hbomax.com',
                'sort_order' => 6,
                'is_active' => true,
            ]
        ];

        foreach ($partners as $partner) {
            TrustedPartner::updateOrCreate(
                ['name' => $partner['name']], // Find by name
                $partner // Update or create with these values
            );
        }
    }
}