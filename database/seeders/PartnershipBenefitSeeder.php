<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PartnershipBenefit;

class PartnershipBenefitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $benefits = [
            [
                'title' => 'Global Reach',
                'description' => 'Access to worldwide audiences through our extensive distribution network spanning 150+ countries and territories.',
                'icon' => 'fas fa-globe',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Revenue Sharing',
                'description' => 'Fair and transparent revenue sharing models with competitive rates and detailed analytics for all partners.',
                'icon' => 'fas fa-chart-line',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Marketing Support',
                'description' => 'Comprehensive marketing and promotional support including social media campaigns, press releases, and targeted advertising.',
                'icon' => 'fas fa-bullhorn',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Analytics & Insights',
                'description' => 'Detailed analytics and insights to optimize your content performance with real-time data and trend analysis.',
                'icon' => 'fas fa-chart-bar',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Technical Support',
                'description' => '24/7 technical support and content delivery optimization to ensure seamless streaming experiences.',
                'icon' => 'fas fa-headset',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Content Protection',
                'description' => 'Advanced DRM and content protection measures to safeguard your intellectual property and prevent piracy.',
                'icon' => 'fas fa-shield-alt',
                'sort_order' => 6,
                'is_active' => true,
            ]
        ];

        foreach ($benefits as $benefit) {
            PartnershipBenefit::create($benefit);
        }
    }
}