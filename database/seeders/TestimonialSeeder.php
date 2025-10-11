<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Sarah Chen',
                'role' => 'Producer, Indie Films Co.',
                'company' => 'Indie Films Co.',
                'content' => 'Working with OSR Digital has been transformative for our independent films. Their distribution network helped us reach audiences we never thought possible.',
                'project' => 'The Last Horizon',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Michael Rodriguez',
                'role' => 'Director, Creative Studios',
                'company' => 'Creative Studios',
                'content' => 'The marketing strategy they developed for our documentary was brilliant. We saw a 300% increase in viewership across all platforms.',
                'project' => 'Rising Stars',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Emma Thompson',
                'role' => 'Executive Producer, Global Media',
                'company' => 'Global Media',
                'content' => 'OSR Digital\'s approach to content acquisition and distribution is both strategic and creative. They\'ve helped us build a strong presence in new markets.',
                'project' => 'Digital Dreams',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'David Park',
                'role' => 'Founder, New Wave Cinema',
                'company' => 'New Wave Cinema',
                'content' => 'Their team\'s passion for storytelling and commitment to quality distribution is evident in everything they do. Highly recommended.',
                'project' => 'Urban Legends',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Lisa Johnson',
                'role' => 'Marketing Director, Art House Films',
                'company' => 'Art House Films',
                'content' => 'OSR Digital helped us navigate the complex world of international distribution. Their expertise and support were invaluable.',
                'project' => 'Behind the Scenes',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'James Wilson',
                'role' => 'Producer, Short Film Collective',
                'company' => 'Short Film Collective',
                'content' => 'The team at OSR Digital understands the unique challenges of short film distribution. They provided us with the perfect platform.',
                'project' => 'Night Shift',
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['name' => $testimonial['name']], // Find by name
                $testimonial // Update or create with these values
            );
        }
    }
}
