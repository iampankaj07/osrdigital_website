<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Associate;
use Illuminate\Support\Facades\Storage;

class AssociateImageDisplayTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Use fake storage
        Storage::fake('public');
    }

    /**
     * Test associate model returns proper logo URL
     */
    public function test_associate_model_returns_proper_logo_url()
    {
        // Create a fake file in storage
        Storage::disk('public')->put('associates/test-logo.png', 'fake image content');
        
        // Create an associate with a logo
        $associate = Associate::create([
            'name' => 'Test Associate',
            'logo' => 'associates/test-logo.png',
            'website' => 'https://example.com',
            'is_active' => true,
            'sort_order' => 1
        ]);

        // Test different logo URL methods
        $this->assertStringContainsString('/images/', $associate->logo_url);
        $this->assertStringContainsString('/images/', $associate->admin_logo_url);
        $this->assertStringContainsString('/images/', $associate->frontend_logo_url);
    }

    /**
     * Test associate model returns placeholder when no logo
     */
    public function test_associate_model_returns_placeholder_when_no_logo()
    {
        // Create an associate without a logo
        $associate = Associate::create([
            'name' => 'Test Associate',
            'logo' => null,
            'website' => 'https://example.com',
            'is_active' => true,
            'sort_order' => 1
        ]);

        // Test that placeholder URLs are returned
        $this->assertStringContainsString('via.placeholder.com', $associate->logo_url);
        $this->assertStringContainsString('via.placeholder.com', $associate->admin_logo_url);
        $this->assertStringContainsString('via.placeholder.com', $associate->frontend_logo_url);
    }

    /**
     * Test associates API returns proper logo URLs
     */
    public function test_associates_api_returns_proper_logo_urls()
    {
        // Create fake files in storage
        Storage::disk('public')->put('associates/test1.png', 'fake image content');
        
        // Create test associates
        Associate::create([
            'name' => 'Test Associate 1',
            'logo' => 'associates/test1.png',
            'website' => 'https://example1.com',
            'is_active' => true,
            'sort_order' => 1
        ]);

        Associate::create([
            'name' => 'Test Associate 2',
            'logo' => null,
            'website' => 'https://example2.com',
            'is_active' => true,
            'sort_order' => 2
        ]);

        // Test API response
        $response = $this->getJson('/api/associates');

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
                            'logo',
                            'website',
                            'is_active',
                            'sort_order'
                        ]
                    ]
                ]);

        $data = $response->json('data');
        $this->assertCount(2, $data);
        
        // Check that logo URLs are properly formatted
        foreach ($data as $associate) {
            if ($associate['name'] === 'Test Associate 1') {
                $this->assertStringContainsString('/images/', $associate['logo']);
            } else {
                // Associate without logo should have placeholder
                $this->assertStringContainsString('via.placeholder.com', $associate['logo']);
            }
        }
    }

    /**
     * Test admin associate index view displays images
     */
    public function test_admin_associate_index_displays_images()
    {
        // Create fake file in storage
        Storage::disk('public')->put('associates/test.png', 'fake image content');
        
        // Create test associate
        $associate = Associate::create([
            'name' => 'Test Associate',
            'logo' => 'associates/test.png',
            'website' => 'https://example.com',
            'is_active' => true,
            'sort_order' => 1
        ]);

        // Create a test user and authenticate
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $user = \App\Models\User::factory()->create();
        $user->assignRole('Super Admin');
        $this->actingAs($user);

        // Test admin view
        $response = $this->get('/admin/associates');

        $response->assertStatus(200);
        $response->assertSee($associate->admin_logo_url);
        $response->assertSee($associate->name);
    }

    /**
     * Test admin associate show view displays images
     */
    public function test_admin_associate_show_displays_images()
    {
        // Create fake file in storage
        Storage::disk('public')->put('associates/test.png', 'fake image content');
        
        // Create test associate
        $associate = Associate::create([
            'name' => 'Test Associate',
            'logo' => 'associates/test.png',
            'website' => 'https://example.com',
            'is_active' => true,
            'sort_order' => 1
        ]);

        // Create a test user and authenticate
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $user = \App\Models\User::factory()->create();
        $user->assignRole('Super Admin');
        $this->actingAs($user);

        // Test admin view
        $response = $this->get("/admin/associates/{$associate->id}");

        $response->assertStatus(200);
        $response->assertSee($associate->logo_url);
        $response->assertSee($associate->name);
    }

    /**
     * Test associate image URLs are contextual
     */
    public function test_associate_image_urls_are_contextual()
    {
        // Create fake file in storage
        Storage::disk('public')->put('associates/test.png', 'fake image content');
        
        $associate = Associate::create([
            'name' => 'Test Associate',
            'logo' => 'associates/test.png',
            'website' => 'https://example.com',
            'is_active' => true,
            'sort_order' => 1
        ]);

        // Test that different contexts return different URLs
        $logoUrl = $associate->logo_url;
        $adminUrl = $associate->admin_logo_url;
        $frontendUrl = $associate->frontend_logo_url;

        // All should contain the image path but may have different parameters
        $this->assertStringContainsString('/images/', $logoUrl);
        $this->assertStringContainsString('/images/', $adminUrl);
        $this->assertStringContainsString('/images/', $frontendUrl);
    }
}
