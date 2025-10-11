<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FilmCategory;

class FilmCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Feature Films',
                'slug' => 'feature-films',
                'description' => 'Full-length feature films and movies',
                'color' => '#3B82F6',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Documentaries',
                'slug' => 'documentaries',
                'description' => 'Documentary films and non-fiction content',
                'color' => '#10B981',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Short Films',
                'slug' => 'short-films',
                'description' => 'Short films and experimental content',
                'color' => '#F59E0B',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Series',
                'slug' => 'series',
                'description' => 'Television series and web series',
                'color' => '#8B5CF6',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Music Videos',
                'slug' => 'music-videos',
                'description' => 'Music videos and promotional content',
                'color' => '#EF4444',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            FilmCategory::create($category);
        }
    }
}
