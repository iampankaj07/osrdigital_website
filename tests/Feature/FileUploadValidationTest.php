<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadValidationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a test user and authenticate
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
        $user = \App\Models\User::factory()->create();
        $user->assignRole('Super Admin');
        $this->actingAs($user);
        
        // Use fake storage
        Storage::fake('public');
    }

    /**
     * Test file upload with different MIME types
     */
    public function test_file_upload_with_different_mime_types()
    {
        $testCases = [
            [
                'file' => UploadedFile::fake()->image('test.png', 300, 300),
                'expected_success' => true,
                'description' => 'PNG image file'
            ],
            [
                'file' => UploadedFile::fake()->create('test.jpg', 1000, 'image/jpeg'),
                'expected_success' => true,
                'description' => 'JPEG image file'
            ],
            [
                'file' => UploadedFile::fake()->create('test.svg', 1000, 'image/svg+xml'),
                'expected_success' => true,
                'description' => 'SVG image file'
            ],
            [
                'file' => UploadedFile::fake()->create('test.txt', 1000, 'text/plain'),
                'expected_success' => false,
                'description' => 'Text file (should fail)'
            ]
        ];

        foreach ($testCases as $testCase) {
            $response = $this->postJson('/upload/associate-image', [
                'logo' => $testCase['file']
            ]);

            if ($testCase['expected_success']) {
                $response->assertStatus(200)
                        ->assertJson(['success' => true]);
                $this->line("✓ {$testCase['description']} - Upload successful");
            } else {
                $response->assertStatus(422)
                        ->assertJson(['success' => false]);
                $this->line("✓ {$testCase['description']} - Upload correctly rejected");
            }
        }
    }

    /**
     * Test file upload with production controller
     */
    public function test_production_file_upload()
    {
        $file = UploadedFile::fake()->image('test.png', 300, 300);
        
        $response = $this->postJson('/upload/associate-image-production', [
            'logo' => $file
        ]);

        $response->assertStatus(200)
                ->assertJson(['success' => true])
                ->assertJsonStructure([
                    'success',
                    'url',
                    'filename',
                    'message'
                ]);
    }

    /**
     * Test file upload with oversized file
     */
    public function test_file_upload_with_oversized_file()
    {
        $file = UploadedFile::fake()->image('test.jpg', 300, 300)->size(3000); // 3MB
        
        $response = $this->postJson('/upload/associate-image', [
            'logo' => $file
        ]);

        $response->assertStatus(422)
                ->assertJson(['success' => false]);
    }

    /**
     * Test file upload without file
     */
    public function test_file_upload_without_file()
    {
        $response = $this->postJson('/upload/associate-image', []);

        $response->assertStatus(422)
                ->assertJson(['success' => false]);
    }
}
