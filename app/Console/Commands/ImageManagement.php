<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ImageHelper;

class ImageManagement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:manage 
                            {action : Action to perform (list|clean|optimize|check|fix)}
                            {--path= : Specific path to process}
                            {--dry-run : Show what would be done without actually doing it}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage images in storage - list, clean, optimize, check, and fix image issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');
        $path = $this->option('path');
        $dryRun = $this->option('dry-run');

        switch ($action) {
            case 'list':
                $this->listImages($path);
                break;
            case 'clean':
                $this->cleanImages($path, $dryRun);
                break;
            case 'optimize':
                $this->optimizeImages($path, $dryRun);
                break;
            case 'check':
                $this->checkImages($path);
                break;
            case 'fix':
                $this->fixImages($path, $dryRun);
                break;
            default:
                $this->error('Invalid action. Available actions: list, clean, optimize, check, fix');
                return 1;
        }

        return 0;
    }

    /**
     * List all images in storage
     */
    protected function listImages($path = null)
    {
        $this->info('Listing images in storage...');
        
        $searchPath = $path ?: 'public';
        $files = Storage::disk('public')->allFiles($searchPath);
        
        $imageFiles = array_filter($files, function($file) {
            return preg_match('/\.(jpg|jpeg|png|gif|webp|svg)$/i', $file);
        });

        if (empty($imageFiles)) {
            $this->warn('No images found in storage.');
            return;
        }

        $this->table(
            ['Path', 'Size', 'Modified', 'URL'],
            array_map(function($file) {
                $size = Storage::disk('public')->size($file);
                $modified = Storage::disk('public')->lastModified($file);
                $url = ImageHelper::getImageUrl($file);
                
                return [
                    $file,
                    $this->formatBytes($size),
                    date('Y-m-d H:i:s', $modified),
                    $url
                ];
            }, $imageFiles)
        );

        $this->info('Total images: ' . count($imageFiles));
    }

    /**
     * Clean up orphaned or invalid images
     */
    protected function cleanImages($path = null, $dryRun = false)
    {
        $this->info('Cleaning up images...');
        
        $searchPath = $path ?: 'public';
        $files = Storage::disk('public')->allFiles($searchPath);
        
        $imageFiles = array_filter($files, function($file) {
            return preg_match('/\.(jpg|jpeg|png|gif|webp|svg)$/i', $file);
        });

        $cleaned = 0;
        $errors = 0;

        foreach ($imageFiles as $file) {
            try {
                $fullPath = Storage::disk('public')->path($file);
                
                // Check if file is valid
                if (!file_exists($fullPath) || filesize($fullPath) === 0) {
                    if (!$dryRun) {
                        Storage::disk('public')->delete($file);
                    }
                    $this->line("Would delete invalid file: {$file}");
                    $cleaned++;
                }
                
                // Check if file is corrupted
                $imageInfo = getimagesize($fullPath);
                if (!$imageInfo) {
                    if (!$dryRun) {
                        Storage::disk('public')->delete($file);
                    }
                    $this->line("Would delete corrupted file: {$file}");
                    $cleaned++;
                }
                
            } catch (\Exception $e) {
                $this->error("Error processing {$file}: " . $e->getMessage());
                $errors++;
            }
        }

        if ($dryRun) {
            $this->info("Dry run complete. Would clean {$cleaned} files with {$errors} errors.");
        } else {
            $this->info("Cleaned {$cleaned} files with {$errors} errors.");
        }
    }

    /**
     * Check image integrity and accessibility
     */
    protected function checkImages($path = null)
    {
        $this->info('Checking images...');
        
        $searchPath = $path ?: 'public';
        $files = Storage::disk('public')->allFiles($searchPath);
        
        $imageFiles = array_filter($files, function($file) {
            return preg_match('/\.(jpg|jpeg|png|gif|webp|svg)$/i', $file);
        });

        $issues = [];
        $totalSize = 0;

        foreach ($imageFiles as $file) {
            try {
                $fullPath = Storage::disk('public')->path($file);
                $size = Storage::disk('public')->size($file);
                $totalSize += $size;
                
                // Check file existence
                if (!file_exists($fullPath)) {
                    $issues[] = "File not found: {$file}";
                    continue;
                }
                
                // Check file size
                if ($size === 0) {
                    $issues[] = "Empty file: {$file}";
                    continue;
                }
                
                // Check if it's a valid image
                $imageInfo = getimagesize($fullPath);
                if (!$imageInfo) {
                    $issues[] = "Invalid image: {$file}";
                    continue;
                }
                
                // Check URL accessibility
                $url = ImageHelper::getImageUrl($file);
                if (ImageHelper::isPlaceholderUrl($url)) {
                    $issues[] = "Using placeholder: {$file}";
                }
                
            } catch (\Exception $e) {
                $issues[] = "Error checking {$file}: " . $e->getMessage();
            }
        }

        $this->info("Total images: " . count($imageFiles));
        $this->info("Total size: " . $this->formatBytes($totalSize));
        
        if (!empty($issues)) {
            $this->warn("Issues found:");
            foreach ($issues as $issue) {
                $this->line("  - {$issue}");
            }
        } else {
            $this->info("All images are valid and accessible.");
        }
    }

    /**
     * Fix common image issues
     */
    protected function fixImages($path = null, $dryRun = false)
    {
        $this->info('Fixing image issues...');
        
        $searchPath = $path ?: 'public';
        $files = Storage::disk('public')->allFiles($searchPath);
        
        $imageFiles = array_filter($files, function($file) {
            return preg_match('/\.(jpg|jpeg|png|gif|webp|svg)$/i', $file);
        });

        $fixed = 0;
        $errors = 0;

        foreach ($imageFiles as $file) {
            try {
                $fullPath = Storage::disk('public')->path($file);
                
                // Fix file permissions
                if (!$dryRun && file_exists($fullPath)) {
                    chmod($fullPath, 0644);
                }
                
                $fixed++;
                
            } catch (\Exception $e) {
                $this->error("Error fixing {$file}: " . $e->getMessage());
                $errors++;
            }
        }

        if ($dryRun) {
            $this->info("Dry run complete. Would fix {$fixed} files with {$errors} errors.");
        } else {
            $this->info("Fixed {$fixed} files with {$errors} errors.");
        }
    }

    /**
     * Optimize images (placeholder for future implementation)
     */
    protected function optimizeImages($path = null, $dryRun = false)
    {
        $this->info('Image optimization not yet implemented.');
        $this->info('This feature will be added in a future update.');
    }

    /**
     * Format bytes to human readable format
     */
    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
