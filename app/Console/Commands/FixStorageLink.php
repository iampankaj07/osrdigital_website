<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class FixStorageLink extends Command
{
    protected $signature = 'storage:fix-link';
    protected $description = 'Fix storage link and ensure proper configuration';

    public function handle()
    {
        $this->info('Fixing storage link...');

        $publicPath = public_path('storage');
        $storagePath = storage_path('app/public');

        $this->line("Public path: {$publicPath}");
        $this->line("Storage path: {$storagePath}");

        // Check if storage directory exists
        if (!is_dir($storagePath)) {
            $this->error("Storage directory does not exist: {$storagePath}");
            return Command::FAILURE;
        }

        // Check if public/storage exists
        if (File::exists($publicPath)) {
            if (File::isLink($publicPath)) {
                $linkTarget = readlink($publicPath);
                if ($linkTarget === $storagePath) {
                    $this->info("✓ Storage link is correct");
                } else {
                    $this->warn("Storage link points to wrong location: {$linkTarget}");
                    $this->info("Removing incorrect link...");
                    File::delete($publicPath);
                }
            } else {
                $this->warn("Public/storage exists but is not a link");
                $this->info("Removing non-link file/directory...");
                if (File::isDirectory($publicPath)) {
                    File::deleteDirectory($publicPath);
                } else {
                    File::delete($publicPath);
                }
            }
        }

        // Create storage link
        if (!File::exists($publicPath)) {
            $this->info("Creating storage link...");
            try {
                Artisan::call('storage:link');
                $this->info("✓ Storage link created successfully");
            } catch (\Exception $e) {
                $this->error("Failed to create storage link: " . $e->getMessage());
                return Command::FAILURE;
            }
        }

        // Verify the link
        if (File::isLink($publicPath) && readlink($publicPath) === $storagePath) {
            $this->info("✓ Storage link verified and working");
        } else {
            $this->error("✗ Storage link verification failed");
            return Command::FAILURE;
        }

        // Test file access
        $testFile = 'test-storage-link.txt';
        $testContent = 'Storage link test - ' . now();
        
        try {
            // Write test file to storage
            file_put_contents($storagePath . '/' . $testFile, $testContent);
            $this->info("✓ Test file written to storage");

            // Read test file through public link
            $publicTestPath = $publicPath . '/' . $testFile;
            if (File::exists($publicTestPath)) {
                $readContent = File::get($publicTestPath);
                if ($readContent === $testContent) {
                    $this->info("✓ Test file readable through public link");
                } else {
                    $this->error("✗ Test file content mismatch");
                }
            } else {
                $this->error("✗ Test file not accessible through public link");
            }

            // Cleanup
            File::delete($storagePath . '/' . $testFile);
            $this->info("✓ Test file cleaned up");

        } catch (\Exception $e) {
            $this->error("Storage link test failed: " . $e->getMessage());
            return Command::FAILURE;
        }

        $this->info("Storage link fix completed successfully!");
        return Command::SUCCESS;
    }
}
