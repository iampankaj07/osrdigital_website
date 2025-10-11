<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestimonialsApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test testimonials API endpoint
     */
    public function test_testimonials_api_returns_success()
    {
        // Create test testimonials
        Testimonial::create([
            'name' => 'Test User',
            'role' => 'Test Role',
            'company' => 'Test Company',
            'content' => 'Test content',
            'is_featured' => true,
            'is_published' => true,
        ]);

        $response = $this->get('/api/testimonials');

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true
                ])
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'role',
                            'company',
                            'content',
                            'avatar_url',
                            'is_featured',
                            'is_published'
                        ]
                    ]
                ]);
    }

    /**
     * Test featured testimonials API endpoint
     */
    public function test_featured_testimonials_api_returns_success()
    {
        // Create test testimonials
        Testimonial::create([
            'name' => 'Featured User',
            'role' => 'Featured Role',
            'company' => 'Featured Company',
            'content' => 'Featured content',
            'is_featured' => true,
            'is_published' => true,
        ]);

        $response = $this->get('/api/testimonials/featured?limit=4');

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true
                ])
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'role',
                            'company',
                            'content',
                            'avatar_url',
                            'is_featured',
                            'is_published'
                        ]
                    ]
                ]);
    }

    /**
     * Test testimonials API with limit parameter
     */
    public function test_testimonials_api_with_limit()
    {
        // Create multiple testimonials
        for ($i = 1; $i <= 5; $i++) {
            Testimonial::create([
                'name' => "User {$i}",
                'role' => "Role {$i}",
                'company' => "Company {$i}",
                'content' => "Content {$i}",
                'is_featured' => true,
                'is_published' => true,
            ]);
        }

        $response = $this->get('/api/testimonials/featured?limit=3');

        $response->assertStatus(200);
        $data = $response->json();
        $this->assertCount(3, $data['data']);
    }

    /**
     * Test testimonials API returns only published testimonials
     */
    public function test_testimonials_api_returns_only_published()
    {
        // Create published testimonial
        Testimonial::create([
            'name' => 'Published User',
            'role' => 'Published Role',
            'company' => 'Published Company',
            'content' => 'Published content',
            'is_featured' => true,
            'is_published' => true,
        ]);

        // Create unpublished testimonial
        Testimonial::create([
            'name' => 'Unpublished User',
            'role' => 'Unpublished Role',
            'company' => 'Unpublished Company',
            'content' => 'Unpublished content',
            'is_featured' => true,
            'is_published' => false,
        ]);

        $response = $this->get('/api/testimonials');

        $response->assertStatus(200);
        $data = $response->json();
        $this->assertCount(1, $data['data']);
        $this->assertEquals('Published User', $data['data'][0]['name']);
    }

    /**
     * Test testimonials API returns only featured testimonials
     */
    public function test_featured_testimonials_api_returns_only_featured()
    {
        // Create featured testimonial
        Testimonial::create([
            'name' => 'Featured User',
            'role' => 'Featured Role',
            'company' => 'Featured Company',
            'content' => 'Featured content',
            'is_featured' => true,
            'is_published' => true,
        ]);

        // Create non-featured testimonial
        Testimonial::create([
            'name' => 'Non-Featured User',
            'role' => 'Non-Featured Role',
            'company' => 'Non-Featured Company',
            'content' => 'Non-Featured content',
            'is_featured' => false,
            'is_published' => true,
        ]);

        $response = $this->get('/api/testimonials/featured');

        $response->assertStatus(200);
        $data = $response->json();
        $this->assertCount(1, $data['data']);
        $this->assertEquals('Featured User', $data['data'][0]['name']);
    }
}