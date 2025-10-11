<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImageHandlingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test ImageHelper basic functionality
     */
    public function test_image_helper_returns_placeholder_for_empty_path()
    {
        $url = ImageHelper::getImageUrl(null);
        
        $this->assertStringContainsString('via.placeholder.com', $url);
    }

    /**
     * Test ImageHelper with valid image path
     */
    public function test_image_helper_returns_storage_url_for_valid_path()
    {
        // Create a test image file
        Storage::disk('public')->put('test-image.jpg', 'fake-image-content');
        
        $url = ImageHelper::getImageUrl('test-image.jpg');
        
        $this->assertStringContainsString('/images/', $url);
        $this->assertStringContainsString('test-image.jpg', $url);
        
        // Clean up
        Storage::disk('public')->delete('test-image.jpg');
    }

    /**
     * Test ImageHelper with full URL
     */
    public function test_image_helper_returns_original_url_for_full_url()
    {
        $originalUrl = 'https://example.com/image.jpg';
        $url = ImageHelper::getImageUrl($originalUrl);
        
        $this->assertEquals($originalUrl, $url);
    }

    /**
     * Test ImageHelper contextual images
     */
    public function test_image_helper_contextual_images()
    {
        $avatarUrl = ImageHelper::getContextualImage(null, 'avatar');
        $this->assertStringContainsString('100x100', $avatarUrl);
        
        $heroUrl = ImageHelper::getContextualImage(null, 'hero');
        $this->assertStringContainsString('1200x600', $heroUrl);
        
        $logoUrl = ImageHelper::getContextualImage(null, 'logo');
        $this->assertStringContainsString('200x100', $logoUrl);
    }

    /**
     * Test ImageHelper placeholder detection
     */
    public function test_image_helper_placeholder_detection()
    {
        $this->assertTrue(ImageHelper::isPlaceholderUrl('https://via.placeholder.com/400x300'));
        $this->assertTrue(ImageHelper::isPlaceholderUrl('https://ui-avatars.com/api/?name=Test'));
        $this->assertFalse(ImageHelper::isPlaceholderUrl('https://example.com/image.jpg'));
    }

    /**
     * Test image route serves images correctly
     */
    public function test_image_route_serves_images()
    {
        // Create a test image file
        Storage::disk('public')->put('test-route-image.jpg', 'fake-image-content');
        
        $response = $this->get('/images/test-route-image.jpg');
        
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/jpeg');
        
        // Clean up
        Storage::disk('public')->delete('test-route-image.jpg');
    }

    /**
     * Test image route returns 404 for non-existent images
     */
    public function test_image_route_returns_404_for_missing_images()
    {
        $response = $this->get('/images/non-existent-image.jpg');
        
        $response->assertStatus(404);
    }

    /**
     * Test placeholder route
     */
    public function test_placeholder_route()
    {
        $response = $this->get('/placeholder/400x300?text=Test');
        
        $response->assertRedirect();
        $this->assertStringContainsString('via.placeholder.com', $response->headers->get('Location'));
        $this->assertStringContainsString('400x300', $response->headers->get('Location'));
    }

    /**
     * Test optimized image route
     */
    public function test_optimized_image_route()
    {
        // Create a test image file
        Storage::disk('public')->put('test-optimized.jpg', 'fake-image-content');
        
        $response = $this->get('/images/optimized/400x300/test-optimized.jpg');
        
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/jpeg');
        
        // Clean up
        Storage::disk('public')->delete('test-optimized.jpg');
    }

    /**
     * Test FilmPortfolio model image handling
     */
    public function test_film_portfolio_image_handling()
    {
        $film = new \App\Models\FilmPortfolio([
            'title' => 'Test Film',
            'featured_image' => 'test-film.jpg'
        ]);
        
        // Mock the image exists
        Storage::disk('public')->put('test-film.jpg', 'fake-image-content');
        
        $imageUrl = $film->image_url;
        $this->assertStringContainsString('/images/', $imageUrl);
        
        // Clean up
        Storage::disk('public')->delete('test-film.jpg');
    }

    /**
     * Test Portfolio model image handling
     */
    public function test_portfolio_image_handling()
    {
        $portfolio = new \App\Models\Portfolio([
            'title' => 'Test Portfolio',
            'featured_image' => 'test-portfolio.jpg'
        ]);
        
        // Mock the image exists
        Storage::disk('public')->put('test-portfolio.jpg', 'fake-image-content');
        
        $imageUrl = $portfolio->image_url;
        $this->assertStringContainsString('/images/', $imageUrl);
        
        // Clean up
        Storage::disk('public')->delete('test-portfolio.jpg');
    }

    /**
     * Test ContentManager logo handling
     */
    public function test_content_manager_logo_handling()
    {
        // Mock settings
        \App\Models\Setting::create([
            'key' => 'site_logo',
            'value' => 'test-logo.jpg'
        ]);
        
        // Mock the image exists
        Storage::disk('public')->put('test-logo.jpg', 'fake-image-content');
        
        $logoUrl = \App\Helpers\ContentManager::getLogoUrl();
        $this->assertStringContainsString('/images/', $logoUrl);
        
        // Clean up
        Storage::disk('public')->delete('test-logo.jpg');
        \App\Models\Setting::where('key', 'site_logo')->delete();
    }
}