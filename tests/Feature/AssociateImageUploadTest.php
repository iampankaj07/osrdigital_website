<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AssociateImageUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Run seeders to create roles
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        
        // Create a test user and authenticate
        $user = \App\Models\User::factory()->create();
        $user->assignRole('Super Admin');
        $this->actingAs($user);
        
        // Use fake storage
        Storage::fake('public');
    }

    /**
     * Test associate image upload with valid file
     */
    public function test_associate_image_upload_with_valid_file()
    {
        $file = UploadedFile::fake()->image('test-logo.png', 300, 300);
        
        $response = $this->postJson('/upload/associate-image', [
            'logo' => $file
        ]);
        
        $response->assertStatus(200)
                ->assertJson([
                    'success' => true
                ])
                ->assertJsonStructure([
                    'success',
                    'url',
                    'filename',
                    'message'
                ]);
        
        // Verify file was stored
        $data = $response->json();
        $this->assertStringContainsString('associates/', $data['filename']);
        $this->assertStringContainsString('/storage/', $data['url']);
        
        // Verify file exists in storage
        Storage::disk('public')->assertExists($data['filename']);
    }

    /**
     * Test associate image upload with invalid file type
     */
    public function test_associate_image_upload_with_invalid_file_type()
    {
        $file = UploadedFile::fake()->create('test.txt', 1000, 'text/plain');
        
        $response = $this->postJson('/upload/associate-image', [
            'logo' => $file
        ]);
        
        $response->assertStatus(422)
                ->assertJson([
                    'success' => false
                ]);
    }

    /**
     * Test associate image upload with oversized file
     */
    public function test_associate_image_upload_with_oversized_file()
    {
        $file = UploadedFile::fake()->image('test-logo.jpg', 300, 300)->size(3000); // 3MB
        
        $response = $this->postJson('/upload/associate-image', [
            'logo' => $file
        ]);
        
        $response->assertStatus(422)
                ->assertJson([
                    'success' => false
                ]);
    }

    /**
     * Test associate image upload without file
     */
    public function test_associate_image_upload_without_file()
    {
        $response = $this->postJson('/upload/associate-image', []);
        
        $response->assertStatus(422)
                ->assertJson([
                    'success' => false
                ]);
    }

    /**
     * Test associate image upload creates directory if not exists
     */
    public function test_associate_image_upload_creates_directory()
    {
        // Ensure associates directory doesn't exist
        Storage::disk('public')->deleteDirectory('associates');
        
        $file = UploadedFile::fake()->image('test-logo.png', 300, 300);
        
        $response = $this->postJson('/upload/associate-image', [
            'logo' => $file
        ]);
        
        $response->assertStatus(200);
        
        // Verify directory was created
        $this->assertTrue(Storage::disk('public')->exists('associates'));
    }

    /**
     * Test associate image upload with old file deletion
     */
    public function test_associate_image_upload_deletes_old_file()
    {
        // Create an old file
        $oldFile = 'associates/old-logo.png';
        Storage::disk('public')->put($oldFile, 'fake content');
        
        $file = UploadedFile::fake()->image('test-logo.png', 300, 300);
        
        $response = $this->postJson('/upload/associate-image', [
            'logo' => $file,
            'old_file' => $oldFile
        ]);
        
        $response->assertStatus(200);
        
        // Verify old file was deleted
        $this->assertFalse(Storage::disk('public')->exists($oldFile));
    }

    /**
     * Test associate image upload with different file formats
     */
    public function test_associate_image_upload_with_different_formats()
    {
        $formats = [
            'png' => UploadedFile::fake()->image('test.png', 300, 300),
            'jpg' => UploadedFile::fake()->image('test.jpg', 300, 300),
            'jpeg' => UploadedFile::fake()->image('test.jpeg', 300, 300),
            'svg' => UploadedFile::fake()->create('test.svg', 1000, 'image/svg+xml'),
        ];
        
        foreach ($formats as $format => $file) {
            $response = $this->postJson('/upload/associate-image', [
                'logo' => $file
            ]);
            
            $response->assertStatus(200)
                    ->assertJson([
                        'success' => true
                    ]);
            
            // Verify file was stored
            $data = $response->json();
            $this->assertStringContainsString($format, $data['filename']);
            Storage::disk('public')->assertExists($data['filename']);
        }
    }
}
