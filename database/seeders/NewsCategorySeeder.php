<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NewsCategory;

class NewsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Company News',
                'slug' => 'company-news',
                'description' => 'Updates and announcements from OSR Digital',
                'color' => '#3B82F6',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Partnerships',
                'slug' => 'partnerships',
                'description' => 'Strategic partnerships and collaborations',
                'color' => '#10B981',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Industry Insights',
                'slug' => 'industry-insights',
                'description' => 'Analysis and trends in digital content distribution',
                'color' => '#F59E0B',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Technology updates and innovations',
                'color' => '#8B5CF6',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Awards & Recognition',
                'slug' => 'awards-recognition',
                'description' => 'Awards, achievements, and recognition',
                'color' => '#EF4444',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            NewsCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
