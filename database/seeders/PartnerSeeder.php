<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            [
                'name' => 'Independent Films Studio',
                'slug' => 'independent-films-studio',
                'partnership_type' => 'studio',
                'description' => 'Award-winning independent film studio specializing in narrative storytelling and documentary production. Known for their innovative approach to filmmaking and commitment to diverse voices.',
                'logo_url' => 'https://via.placeholder.com/200x100/ef4444/ffffff?text=IFS',
                'website_url' => 'https://independentfilms.example',
                'contact_email' => 'contact@independentfilms.example',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Global Music Network',
                'slug' => 'global-music-network',
                'partnership_type' => 'distributor',
                'description' => 'International music distribution network connecting artists with global audiences across multiple platforms including streaming services, digital stores, and social media.',
                'logo_url' => 'https://via.placeholder.com/200x100/3b82f6/ffffff?text=GMN',
                'website_url' => 'https://globalmusicnetwork.example',
                'contact_email' => 'partnerships@gmn.example',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Creative Collective',
                'slug' => 'creative-collective',
                'partnership_type' => 'creator',
                'description' => 'Collective of emerging filmmakers and content creators pushing the boundaries of digital storytelling through experimental formats and interactive media.',
                'logo_url' => 'https://via.placeholder.com/200x100/10b981/ffffff?text=CC',
                'website_url' => 'https://creativecollective.example',
                'contact_email' => 'hello@creativecollective.example',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'StreamVision Platform',
                'slug' => 'streamvision-platform',
                'partnership_type' => 'platform',
                'description' => 'Next-generation streaming platform focused on immersive content experiences and cutting-edge technology integration for content creators and audiences.',
                'logo_url' => 'https://via.placeholder.com/200x100/8b5cf6/ffffff?text=SVP',
                'website_url' => 'https://streamvision.example',
                'contact_email' => 'content@streamvision.example',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Digital Arts Foundation',
                'slug' => 'digital-arts-foundation',
                'partnership_type' => 'creator',
                'description' => 'Non-profit organization supporting digital artists and filmmakers through grants, mentorship programs, and collaborative projects focused on social impact storytelling.',
                'logo_url' => 'https://via.placeholder.com/200x100/f59e0b/ffffff?text=DAF',
                'website_url' => 'https://digitalartsfoundation.example',
                'contact_email' => 'grants@digitalarts.example',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Innovation Studios',
                'slug' => 'innovation-studios',
                'partnership_type' => 'studio',
                'description' => 'Technology-driven studio specializing in virtual production, AR/VR content, and immersive storytelling experiences for brands and entertainment.',
                'logo_url' => 'https://via.placeholder.com/200x100/ec4899/ffffff?text=IS',
                'website_url' => 'https://innovationstudios.example',
                'contact_email' => 'tech@innovationstudios.example',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Worldwide Content Distribution',
                'slug' => 'worldwide-content-distribution',
                'partnership_type' => 'distributor',
                'description' => 'Global distribution powerhouse with extensive network covering theatrical, streaming, and international sales across 80+ countries worldwide.',
                'logo_url' => 'https://via.placeholder.com/200x100/06b6d4/ffffff?text=WCD',
                'website_url' => 'https://worldwidecontent.example',
                'contact_email' => 'sales@worldwidecontent.example',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'NextGen Distribution',
                'slug' => 'nextgen-distribution',
                'partnership_type' => 'distributor',
                'description' => 'Modern distribution company leveraging data analytics and AI to optimize content placement and audience targeting across emerging digital platforms.',
                'logo_url' => 'https://via.placeholder.com/200x100/7c3aed/ffffff?text=NGD',
                'website_url' => 'https://nextgendist.example',
                'contact_email' => 'partners@nextgendist.example',
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Infinite Reach Media',
                'slug' => 'infinite-reach-media',
                'partnership_type' => 'platform',
                'description' => 'Multi-platform media network specializing in content syndication across emerging digital channels and international markets.',
                'logo_url' => 'https://via.placeholder.com/200x100/84cc16/ffffff?text=IRM',
                'website_url' => 'https://infinitereach.example',
                'contact_email' => 'collaboration@infinitereach.example',
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'name' => 'Visionary Creators Network',
                'slug' => 'visionary-creators-network',
                'partnership_type' => 'creator',
                'description' => 'Network of award-winning directors, producers, and writers collaborating on high-impact projects that challenge conventional storytelling methods.',
                'logo_url' => 'https://via.placeholder.com/200x100/dc2626/ffffff?text=VCN',
                'website_url' => 'https://visionarycreators.example',
                'contact_email' => 'network@visionarycreators.example',
                'is_active' => true,
                'sort_order' => 10,
            ]
        ];

        foreach ($partners as $partner) {
            Partner::create($partner);
        }
    }
}
