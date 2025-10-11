<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class CheckProductionStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:check-production 
                            {--fix : Attempt to fix production storage issues}
                            {--test-upload : Test file upload simulation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and fix storage configuration for production environment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking production storage configuration...');
        
        $issues = [];
        $fixes = [];
        
        // Check environment
        $this->line("Environment: " . app()->environment());
        $this->line("App URL: " . config('app.url'));
        $this->line("Filesystem Disk: " . config('filesystems.default'));
        
        // Check storage directory
        $storagePath = storage_path('app/public');
        $this->line("Storage path: {$storagePath}");
        
        if (!File::exists($storagePath)) {
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
        if (File::exists($storagePath)) {
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
        
        if (!is_link($linkPath) || !File::exists($linkPath)) {
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
            if (!File::exists($dirPath)) {
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
                $this->line("✓ Directory exists: {$dir}");
            }
        }
        
        // Test file operations using File facade
        $this->info('Testing file operations with File facade...');
        try {
            $testFile = 'test-' . time() . '.txt';
            $testContent = 'Test file content for production';
            $testPath = $storagePath . '/' . $testFile;
            
            // Test write
            File::put($testPath, $testContent);
            
            // Test read
            $readContent = File::get($testPath);
            if ($readContent === $testContent) {
                $this->line("✓ File read/write test passed");
            } else {
                $issues[] = "File read/write test failed - content mismatch";
            }
            
            // Test exists
            if (File::exists($testPath)) {
                $this->line("✓ File exists test passed");
            } else {
                $issues[] = "File exists test failed";
            }
            
            // Test size
            $size = File::size($testPath);
            $this->line("✓ File size test passed: {$size} bytes");
            
            // Cleanup
            File::delete($testPath);
            
        } catch (\Exception $e) {
            $issues[] = "File operations test failed: " . $e->getMessage();
        }
        
        // Test Storage facade
        $this->info('Testing Storage facade operations...');
        try {
            $testFile = 'storage-test-' . time() . '.txt';
            $testContent = 'Storage facade test content';
            
            // Test write
            Storage::disk('public')->put($testFile, $testContent);
            
            // Test read
            $readContent = Storage::disk('public')->get($testFile);
            if ($readContent === $testContent) {
                $this->line("✓ Storage facade read/write test passed");
            } else {
                $issues[] = "Storage facade read/write test failed - content mismatch";
            }
            
            // Test exists
            if (Storage::disk('public')->exists($testFile)) {
                $this->line("✓ Storage facade exists test passed");
            } else {
                $issues[] = "Storage facade exists test failed";
            }
            
            // Test URL
            $url = Storage::disk('public')->url($testFile);
            if (!empty($url)) {
                $this->line("✓ Storage facade URL test passed: {$url}");
            } else {
                $issues[] = "Storage facade URL test failed";
            }
            
            // Cleanup
            Storage::disk('public')->delete($testFile);
            
        } catch (\Exception $e) {
            $issues[] = "Storage facade test failed: " . $e->getMessage();
        }
        
        // Test file upload simulation if requested
        if ($this->option('test-upload')) {
            $this->testFileUploadSimulation();
        }
        
        // Summary
        $this->info("\n" . str_repeat('=', 50));
        $this->info('Production Storage Check Summary');
        $this->info(str_repeat('=', 50));
        
        if (empty($issues)) {
            $this->info('✓ All production storage checks passed!');
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
            $this->warn("php artisan storage:check-production --fix");
        }
        
        return empty($issues) ? 0 : 1;
    }
    
    private function testFileUploadSimulation()
    {
        $this->info('Testing file upload simulation...');
        
        try {
            // Create a temporary file
            $tempFile = tempnam(sys_get_temp_dir(), 'test_upload');
            file_put_contents($tempFile, 'Test image content for production upload');
            
            // Create UploadedFile instance
            $uploadedFile = new UploadedFile(
                $tempFile,
                'test-image.png',
                'image/png',
                null,
                true
            );
            
            $this->line("✓ UploadedFile created: " . $uploadedFile->getClientOriginalName());
            $this->line("✓ File size: " . $uploadedFile->getSize() . " bytes");
            $this->line("✓ MIME type: " . $uploadedFile->getMimeType());
            $this->line("✓ Is valid: " . ($uploadedFile->isValid() ? 'Yes' : 'No'));
            
            // Test storage with UploadedFile using File facade
            $filename = 'test-uploads/test-' . Str::uuid() . '.png';
            $targetPath = storage_path('app/public/' . $filename);
            $targetDir = dirname($targetPath);
            
            if (!File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }
            
            if (File::copy($uploadedFile->getPathname(), $targetPath)) {
                $this->line("✓ File upload simulation successful: {$filename}");
                $this->line("✓ URL: " . config('app.url') . '/storage/' . $filename);
                
                // Cleanup
                File::delete($targetPath);
                $this->line("✓ Upload test cleanup completed");
            } else {
                $this->error("✗ File upload simulation failed");
            }
            
            // Cleanup temp file
            unlink($tempFile);
            
        } catch (\Exception $e) {
            $this->error("✗ File upload test failed: " . $e->getMessage());
        }
    }
}
