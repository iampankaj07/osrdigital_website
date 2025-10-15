<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FilmPortfolio;
use App\Models\FilmCategory;

class FilmPortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $featureFilms = FilmCategory::where('slug', 'feature-films')->first();
        $documentaries = FilmCategory::where('slug', 'documentaries')->first();
        $shortFilms = FilmCategory::where('slug', 'short-films')->first();
        $series = FilmCategory::where('slug', 'series')->first();

        $films = [
            [
                'title' => 'The Last Horizon',
                'slug' => 'the-last-horizon',
                'description' => 'A gripping sci-fi thriller about humanity\'s final journey to the stars.',
                'genre' => 'Sci-Fi Thriller',
                'year' => 2024,
                'image_url' => 'https://images.unsplash.com/photo-1489599803000-4b0b0b0b0b0b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'rating' => 8.5,
                'duration' => '2h 15m',
                'category_id' => $featureFilms->id,
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
                'views' => 1250,
            ],
            [
                'title' => 'Urban Legends',
                'slug' => 'urban-legends',
                'description' => 'A chilling horror anthology exploring modern urban myths.',
                'genre' => 'Horror',
                'year' => 2024,
                'image_url' => 'https://images.unsplash.com/photo-1574269909862-7e1d70bb8078?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'rating' => 7.8,
                'duration' => '1h 45m',
                'category_id' => $featureFilms->id,
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
                'views' => 980,
            ],
            [
                'title' => 'Rising Stars',
                'slug' => 'rising-stars',
                'description' => 'An inspiring documentary about young artists breaking into the industry.',
                'genre' => 'Documentary',
                'year' => 2023,
                'image_url' => 'https://images.unsplash.com/photo-1594909122845-11baa439b7bf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'rating' => 9.2,
                'duration' => '1h 30m',
                'category_id' => $documentaries->id,
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Digital Dreams',
                'slug' => 'digital-dreams',
                'description' => 'A poignant drama about technology\'s impact on human relationships.',
                'genre' => 'Drama',
                'year' => 2024,
                'image_url' => 'https://images.unsplash.com/photo-1489599803000-4b0b0b0b0b0b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'rating' => 8.1,
                'duration' => '1h 55m',
                'category_id' => $featureFilms->id,
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Behind the Scenes',
                'slug' => 'behind-the-scenes',
                'description' => 'An exclusive look at the making of blockbuster films.',
                'genre' => 'Documentary',
                'year' => 2023,
                'image_url' => 'https://images.unsplash.com/photo-1574269909862-7e1d70bb8078?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'rating' => 8.7,
                'duration' => '2h 10m',
                'category_id' => $documentaries->id,
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'Night Shift',
                'slug' => 'night-shift',
                'description' => 'A tense thriller set in a 24-hour convenience store.',
                'genre' => 'Thriller',
                'year' => 2024,
                'image_url' => 'https://images.unsplash.com/photo-1594909122845-11baa439b7bf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                'rating' => 7.9,
                'duration' => '1h 40m',
                'category_id' => $shortFilms->id,
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($films as $film) {
            FilmPortfolio::create($film);
        }
    }
}
