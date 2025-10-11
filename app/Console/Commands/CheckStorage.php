<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CheckStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:check 
                            {--fix : Attempt to fix storage issues}
                            {--detailed : Show detailed information}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check storage configuration and permissions for file uploads';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking storage configuration...');
        
        $issues = [];
        $fixes = [];
        
        // Check storage directory
        $storagePath = storage_path('app/public');
        $this->line("Storage path: {$storagePath}");
        
        if (!is_dir($storagePath)) {
            $issues[] = "Storage directory does not exist: {$storagePath}";
            if ($this->option('fix')) {
                try {
                    File::makeDirectory($storagePath, 0755, true);
                    $fixes[] = "Created storage directory: {$storagePath}";
                } catch (\Exception $e) {
                    $issues[] = "Failed to create storage directory: " . $e->getMessage();
                }
            }
        } else {
            $this->line("✓ Storage directory exists");
        }
        
        // Check storage permissions
        if (is_dir($storagePath)) {
            if (!is_writable($storagePath)) {
                $issues[] = "Storage directory is not writable: {$storagePath}";
                if ($this->option('fix')) {
                    try {
                        chmod($storagePath, 0755);
                        $fixes[] = "Set storage directory permissions to 0755";
                    } catch (\Exception $e) {
                        $issues[] = "Failed to set storage permissions: " . $e->getMessage();
                    }
                }
            } else {
                $this->line("✓ Storage directory is writable");
            }
        }
        
        // Check storage link
        $linkPath = public_path('storage');
        $this->line("Storage link: {$linkPath}");
        
        if (!is_link($linkPath) || !file_exists($linkPath)) {
            $issues[] = "Storage link does not exist or is broken: {$linkPath}";
            if ($this->option('fix')) {
                try {
                    if (is_link($linkPath)) {
                        unlink($linkPath);
                    }
                    symlink($storagePath, $linkPath);
                    $fixes[] = "Created storage link: {$linkPath}";
                } catch (\Exception $e) {
                    $issues[] = "Failed to create storage link: " . $e->getMessage();
                }
            }
        } else {
            $this->line("✓ Storage link exists and is valid");
        }
        
        // Check required directories
        $requiredDirs = [
            'associates',
            'film-portfolios',
            'team-avatars',
            'testimonials',
            'partner-logos',
            'news',
            'general',
        ];
        
        foreach ($requiredDirs as $dir) {
            $dirPath = $storagePath . '/' . $dir;
            if (!is_dir($dirPath)) {
                $issues[] = "Required directory does not exist: {$dir}";
                if ($this->option('fix')) {
                    try {
                        File::makeDirectory($dirPath, 0755, true);
                        $fixes[] = "Created directory: {$dir}";
                    } catch (\Exception $e) {
                        $issues[] = "Failed to create directory {$dir}: " . $e->getMessage();
                    }
                }
            } else {
                if ($this->option('detailed')) {
                    $this->line("✓ Directory exists: {$dir}");
                }
            }
        }
        
        // Test file operations
        $this->info('Testing file operations...');
        try {
            $testFile = 'test-' . time() . '.txt';
            $testContent = 'Test file content';
            
            // Test write
            Storage::disk('public')->put($testFile, $testContent);
            
            // Test read
            $readContent = Storage::disk('public')->get($testFile);
            if ($readContent !== $testContent) {
                $issues[] = "File read/write test failed - content mismatch";
            } else {
                $this->line("✓ File read/write test passed");
            }
            
            // Test exists
            if (!Storage::disk('public')->exists($testFile)) {
                $issues[] = "File exists test failed";
            } else {
                $this->line("✓ File exists test passed");
            }
            
            // Test URL generation
            $url = Storage::disk('public')->url($testFile);
            if (empty($url)) {
                $issues[] = "URL generation test failed";
            } else {
                $this->line("✓ URL generation test passed: {$url}");
            }
            
            // Cleanup
            Storage::disk('public')->delete($testFile);
            
        } catch (\Exception $e) {
            $issues[] = "File operations test failed: " . $e->getMessage();
        }
        
        // Check Laravel configuration
        $this->info('Checking Laravel configuration...');
        $defaultDisk = config('filesystems.default');
        $publicDisk = config('filesystems.disks.public');
        
        $this->line("Default disk: {$defaultDisk}");
        $this->line("Public disk root: " . ($publicDisk['root'] ?? 'not set'));
        $this->line("Public disk url: " . ($publicDisk['url'] ?? 'not set'));
        
        if ($defaultDisk !== 'public') {
            $issues[] = "Default filesystem disk is not 'public'";
        }
        
        // Summary
        $this->info("\n" . str_repeat('=', 50));
        $this->info('Storage Check Summary');
        $this->info(str_repeat('=', 50));
        
        if (empty($issues)) {
            $this->info('✓ All storage checks passed!');
        } else {
            $this->error('Issues found:');
            foreach ($issues as $issue) {
                $this->error("  ✗ {$issue}");
            }
        }
        
        if (!empty($fixes)) {
            $this->info('Fixes applied:');
            foreach ($fixes as $fix) {
                $this->info("  ✓ {$fix}");
            }
        }
        
        if (!empty($issues)) {
            $this->warn("\nTo fix issues automatically, run:");
            $this->warn("php artisan storage:check --fix");
        }
        
        return empty($issues) ? 0 : 1;
    }
}
