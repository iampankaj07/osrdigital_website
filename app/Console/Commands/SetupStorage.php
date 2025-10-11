<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SetupStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:setup 
                            {--force : Force creation even if directories exist}
                            {--permissions : Set proper permissions}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup storage directories and permissions for file uploads';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Setting up storage directories...');
        
        $directories = [
            'associates',
            'film-portfolios',
            'team-avatars',
            'testimonials',
            'partner-logos',
            'news',
            'general',
        ];
        
        $created = 0;
        $errors = 0;
        
        foreach ($directories as $directory) {
            try {
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory);
                    $this->line("✓ Created directory: {$directory}");
                    $created++;
                } else {
                    $this->line("✓ Directory already exists: {$directory}");
                }
                
                // Set permissions if requested
                if ($this->option('permissions')) {
                    $fullPath = storage_path('app/public/' . $directory);
                    if (is_dir($fullPath)) {
                        chmod($fullPath, 0755);
                        $this->line("✓ Set permissions for: {$directory}");
                    }
                }
                
            } catch (\Exception $e) {
                $this->error("✗ Failed to create directory {$directory}: " . $e->getMessage());
                $errors++;
            }
        }
        
        // Ensure storage link exists
        $this->info('Checking storage link...');
        $linkPath = public_path('storage');
        $targetPath = storage_path('app/public');
        
        if (!is_link($linkPath) || !file_exists($linkPath)) {
            try {
                if (is_link($linkPath)) {
                    unlink($linkPath);
                }
                symlink($targetPath, $linkPath);
                $this->line("✓ Created storage link");
            } catch (\Exception $e) {
                $this->error("✗ Failed to create storage link: " . $e->getMessage());
                $this->warn("Run: php artisan storage:link");
                $errors++;
            }
        } else {
            $this->line("✓ Storage link already exists");
        }
        
        // Check permissions
        $this->info('Checking storage permissions...');
        $storagePath = storage_path('app/public');
        
        if (!is_writable($storagePath)) {
            $this->warn("⚠ Storage directory is not writable: {$storagePath}");
            $this->warn("Run: chmod -R 755 {$storagePath}");
        } else {
            $this->line("✓ Storage directory is writable");
        }
        
        // Summary
        $this->info("\nSetup Summary:");
        $this->line("Directories created: {$created}");
        $this->line("Errors: {$errors}");
        
        if ($errors === 0) {
            $this->info("✓ Storage setup completed successfully!");
        } else {
            $this->warn("⚠ Storage setup completed with {$errors} errors");
        }
        
        return $errors === 0 ? 0 : 1;
    }
}
