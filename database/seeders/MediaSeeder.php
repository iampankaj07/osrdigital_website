<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Media;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating sample media files...');

        // Get the first admin user
        $adminUser = User::whereHas('roles', function($query) {
            $query->where('name', 'Super Admin');
        })->first();

        if (!$adminUser) {
            $this->command->error('No admin user found. Please run AdminUserSeeder first.');
            return;
        }

        // Create sample media entries
        $sampleMedia = [
            [
                'name' => 'OSR Logo',
                'filename' => 'osr-logo.png',
                'path' => 'media/osr-logo.png',
                'url' => '/storage/media/osr-logo.png',
                'mime_type' => 'image/png',
                'extension' => 'png',
                'size' => 15420,
                'width' => 200,
                'height' => 100,
                'alt_text' => 'OSR Digital Logo',
                'description' => 'Official OSR Digital company logo',
                'category' => 'logos',
                'is_public' => true,
                'uploaded_by' => $adminUser->id,
                'metadata' => [
                    'original_name' => 'osr-logo.png',
                    'uploaded_at' => now()->toISOString(),
                    'source' => 'seeder'
                ],
            ],
            [
                'name' => 'Team Photo',
                'filename' => 'team-photo.jpg',
                'path' => 'media/team-photo.jpg',
                'url' => '/storage/media/team-photo.jpg',
                'mime_type' => 'image/jpeg',
                'extension' => 'jpg',
                'size' => 25680,
                'width' => 800,
                'height' => 600,
                'alt_text' => 'OSR Digital Team',
                'description' => 'Our amazing team at OSR Digital',
                'category' => 'team',
                'is_public' => true,
                'uploaded_by' => $adminUser->id,
                'metadata' => [
                    'original_name' => 'team-photo.jpg',
                    'uploaded_at' => now()->toISOString(),
                    'source' => 'seeder'
                ],
            ],
            [
                'name' => 'Company Brochure',
                'filename' => 'company-brochure.pdf',
                'path' => 'media/company-brochure.pdf',
                'url' => '/storage/media/company-brochure.pdf',
                'mime_type' => 'application/pdf',
                'extension' => 'pdf',
                'size' => 1024000,
                'width' => null,
                'height' => null,
                'alt_text' => 'OSR Digital Company Brochure',
                'description' => 'Download our company brochure to learn more about our services',
                'category' => 'documents',
                'is_public' => true,
                'uploaded_by' => $adminUser->id,
                'metadata' => [
                    'original_name' => 'company-brochure.pdf',
                    'uploaded_at' => now()->toISOString(),
                    'source' => 'seeder'
                ],
            ],
            [
                'name' => 'Banner Image',
                'filename' => 'banner-image.jpg',
                'path' => 'media/banner-image.jpg',
                'url' => '/storage/media/banner-image.jpg',
                'mime_type' => 'image/jpeg',
                'extension' => 'jpg',
                'size' => 45680,
                'width' => 1200,
                'height' => 400,
                'alt_text' => 'OSR Digital Banner',
                'description' => 'Main banner image for website',
                'category' => 'banners',
                'is_public' => true,
                'uploaded_by' => $adminUser->id,
                'metadata' => [
                    'original_name' => 'banner-image.jpg',
                    'uploaded_at' => now()->toISOString(),
                    'source' => 'seeder'
                ],
            ],
            [
                'name' => 'Service Icon',
                'filename' => 'service-icon.svg',
                'path' => 'media/service-icon.svg',
                'url' => '/storage/media/service-icon.svg',
                'mime_type' => 'image/svg+xml',
                'extension' => 'svg',
                'size' => 2340,
                'width' => 64,
                'height' => 64,
                'alt_text' => 'Service Icon',
                'description' => 'Icon representing our services',
                'category' => 'icons',
                'is_public' => true,
                'uploaded_by' => $adminUser->id,
                'metadata' => [
                    'original_name' => 'service-icon.svg',
                    'uploaded_at' => now()->toISOString(),
                    'source' => 'seeder'
                ],
            ],
        ];

        foreach ($sampleMedia as $mediaData) {
            Media::create($mediaData);
            $this->command->info("Created media: {$mediaData['name']}");
        }

        $this->command->info('Sample media files created successfully!');
        $this->command->info('Note: These are placeholder entries. Actual files need to be uploaded through the media library.');
    }
}
