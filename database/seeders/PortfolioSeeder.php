<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $portfolioItems = [
            [
                'title' => 'Midnight Chronicles',
                'slug' => 'midnight-chronicles',
                'description' => 'A gripping thriller that explores the dark side of urban life through the eyes of a detective investigating mysterious disappearances in the city.',
                'type' => 'movie',
                'image_url' => 'https://images.pexels.com/photos/7991579/pexels-photo-7991579.jpeg?auto=compress&cs=tinysrgb&w=1200',
                'video_url' => 'https://youtube.com/watch?v=example1',
                'views' => '2500000',
                'category' => 'Thriller',
                'metadata' => json_encode([
                    'duration' => '118',
                    'director' => 'Michael Rodriguez',
                    'cast' => ['Sarah Chen - Emma Stone', 'Detective Ray Wilson - Oscar Isaac', 'Captain Martinez - Lupita Nyong\'o'],
                    'genre' => ['Thriller', 'Crime', 'Drama'],
                    'trailer_url' => 'https://youtube.com/watch?v=trailer1',
                    'release_date' => '2024-01-15'
                ]),
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Summer Vibes',
                'slug' => 'summer-vibes',
                'description' => 'An uplifting music video that captures the essence of summer with vibrant visuals and an infectious beat that celebrates youth and freedom.',
                'type' => 'music',
                'image_url' => 'https://images.pexels.com/photos/1763075/pexels-photo-1763075.jpeg?auto=compress&cs=tinysrgb&w=1200',
                'video_url' => 'https://youtube.com/watch?v=example2',
                'views' => '1800000',
                'category' => 'Pop',
                'metadata' => json_encode([
                    'duration' => '4',
                    'artist' => 'Luna Martinez',
                    'producer' => 'David Kim',
                    'genre' => ['Pop', 'Dance', 'Electronic'],
                    'release_date' => '2024-01-20'
                ]),
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'The Last Stand',
                'slug' => 'the-last-stand',
                'description' => 'A powerful short film about resilience and hope in the face of adversity, following a community\'s struggle to preserve their heritage.',
                'type' => 'short_film',
                'image_url' => 'https://images.pexels.com/photos/7991319/pexels-photo-7991319.jpeg?auto=compress&cs=tinysrgb&w=1200',
                'video_url' => 'https://youtube.com/watch?v=example3',
                'views' => '950000',
                'category' => 'Drama',
                'metadata' => json_encode([
                    'duration' => '15',
                    'director' => 'Ana Gutierrez',
                    'cast' => ['Elena Vasquez - Sofia Vergara', 'Carlos Mendoza - John Leguizamo', 'Maria Santos - Eva Longoria'],
                    'genre' => ['Drama', 'Documentary'],
                    'awards' => ['Best Short Film - Sundance 2024', 'Audience Choice - TIFF 2024'],
                    'release_date' => '2024-01-10'
                ]),
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title' => 'Urban Legends',
                'slug' => 'urban-legends',
                'description' => 'A documentary series exploring modern urban legends and their impact on contemporary culture and social media.',
                'type' => 'movie',
                'image_url' => 'https://images.pexels.com/photos/3183150/pexels-photo-3183150.jpeg?auto=compress&cs=tinysrgb&w=1200',
                'video_url' => 'https://youtube.com/watch?v=example4',
                'views' => '1200000',
                'category' => 'Documentary',
                'metadata' => json_encode([
                    'duration' => '45',
                    'director' => 'James Wilson',
                    'genre' => ['Documentary', 'Mystery'],
                    'release_date' => '2024-02-01'
                ]),
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Neon Dreams',
                'slug' => 'neon-dreams',
                'description' => 'A synthwave music video that transports viewers to a retro-futuristic world of neon lights and electronic sounds.',
                'type' => 'music',
                'image_url' => 'https://images.pexels.com/photos/2747449/pexels-photo-2747449.jpeg?auto=compress&cs=tinysrgb&w=1200',
                'video_url' => 'https://youtube.com/watch?v=example5',
                'views' => '890000',
                'category' => 'Synthwave',
                'metadata' => json_encode([
                    'duration' => '5',
                    'artist' => 'Neon Collective',
                    'producer' => 'Alex Chen',
                    'genre' => ['Synthwave', 'Electronic', 'Retro'],
                    'release_date' => '2024-02-10'
                ]),
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title' => 'Voices Unheard',
                'slug' => 'voices-unheard',
                'description' => 'A powerful short documentary giving voice to marginalized communities and their untold stories.',
                'type' => 'short_film',
                'image_url' => 'https://images.pexels.com/photos/3183197/pexels-photo-3183197.jpeg?auto=compress&cs=tinysrgb&w=1200',
                'video_url' => 'https://youtube.com/watch?v=example6',
                'views' => '750000',
                'category' => 'Documentary',
                'metadata' => json_encode([
                    'duration' => '12',
                    'director' => 'Maya Patel',
                    'genre' => ['Documentary', 'Social'],
                    'awards' => ['Social Impact Award - Cannes 2024'],
                    'release_date' => '2024-02-15'
                ]),
                'is_featured' => false,
                'is_published' => true,
            ]
        ];

        foreach ($portfolioItems as $item) {
            Portfolio::create($item);
        }
    }
}
