<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SetupStorageWithoutSymlink extends Command
{
    protected $signature = 'storage:setup-no-symlink 
                            {--copy : Copy existing files from storage to public/storage}
                            {--force : Force recreation of public/storage directory}';
    
    protected $description = 'Set up storage for shared hosting without using symlinks';

    public function handle()
    {
        $this->info('Setting up storage for shared hosting (no symlinks)...');

        // Detect public directory (public_html for shared hosting, public for standard)
        $publicDir = $this->detectPublicDirectory();
        $publicStoragePath = $publicDir . '/storage';
        $storagePath = storage_path('app/public');
        
        $this->line("Public directory: {$publicDir}");
        $this->line("Public storage path: {$publicStoragePath}");

        // Check if storage directory exists
        if (!is_dir($storagePath)) {
            $this->error("Storage directory does not exist: {$storagePath}");
            $this->info("Creating storage directory...");
            File::makeDirectory($storagePath, 0755, true);
        }

        // Remove existing symlink if it exists
        if (is_link($publicStoragePath)) {
            $this->warn("Removing existing symlink...");
            unlink($publicStoragePath);
        }

        // Create public/storage as a real directory (not symlink)
        if ($this->option('force') && is_dir($publicStoragePath)) {
            $this->warn("Removing existing public/storage directory...");
            File::deleteDirectory($publicStoragePath);
        }

        if (!is_dir($publicStoragePath)) {
            $this->info("Creating public/storage directory...");
            File::makeDirectory($publicStoragePath, 0755, true);
            $this->info("✓ Created public/storage directory");
        } else {
            $this->info("✓ public/storage directory already exists");
        }

        // Copy files if requested
        if ($this->option('copy') && is_dir($storagePath)) {
            $this->info("Copying files from storage to public/storage...");
            $this->copyDirectory($storagePath, $publicStoragePath);
        }

        // Create .htaccess in public/storage for security
        $htaccessPath = $publicStoragePath . '/.htaccess';
        if (!File::exists($htaccessPath)) {
            $htaccessContent = <<<'HTACCESS'
# Deny access to PHP files
<FilesMatch "\.php$">
    Order allow,deny
    Deny from all
</FilesMatch>

# Allow access to images and other media
<FilesMatch "\.(jpg|jpeg|png|gif|webp|svg|ico|pdf|mp4|mp3|zip)$">
    Order allow,deny
    Allow from all
</FilesMatch>
HTACCESS;
            File::put($htaccessPath, $htaccessContent);
            $this->info("✓ Created .htaccess in public/storage");
        }

        // Create required subdirectories
        $requiredDirs = [
            'associates',
            'film-portfolios',
            'team-avatars',
            'testimonials',
            'partner-logos',
            'news',
            'general',
            'hero-sliders',
        ];

        foreach ($requiredDirs as $dir) {
            $dirPath = $publicStoragePath . '/' . $dir;
            if (!is_dir($dirPath)) {
                File::makeDirectory($dirPath, 0755, true);
                $this->line("✓ Created directory: {$dir}");
            }
        }

        // Also create in storage/app/public
        foreach ($requiredDirs as $dir) {
            $dirPath = $storagePath . '/' . $dir;
            if (!is_dir($dirPath)) {
                File::makeDirectory($dirPath, 0755, true);
            }
        }

        $this->info("\n✓ Storage setup completed without symlinks!");
        $this->warn("\n⚠️  IMPORTANT: Update your .env file:");
        $this->line("   Set: STORAGE_TYPE=copy");
        if ($publicDir !== public_path()) {
            $this->line("   Set: PUBLIC_PATH={$publicDir}");
        }
        $this->line("   This will make Laravel copy files to {$publicDir}/storage instead of using symlinks.");

        return Command::SUCCESS;
    }

    /**
     * Detect the public directory (public_html for shared hosting, public for standard)
     * Handles both structures:
     * - public_html inside project: /home/username/project/public_html
     * - public_html as sibling: /home/username/public_html (project is /home/username/osr)
     */
    protected function detectPublicDirectory(): string
    {
        // Check environment variable first (highest priority)
        $envPublicPath = env('PUBLIC_PATH');
        if ($envPublicPath && is_dir($envPublicPath)) {
            return $envPublicPath;
        }

        // Check for public_html as sibling directory (common shared hosting structure)
        // If project is in /home/username/osr, check /home/username/public_html
        $basePath = base_path();
        $parentDir = dirname($basePath);
        $siblingPublicHtml = $parentDir . '/public_html';
        if (is_dir($siblingPublicHtml)) {
            return $siblingPublicHtml;
        }

        // Check for public_html inside project directory
        $publicHtmlPath = base_path('public_html');
        if (is_dir($publicHtmlPath)) {
            return $publicHtmlPath;
        }

        // Check if public_path() points to public_html
        $standardPublicPath = public_path();
        if (str_contains($standardPublicPath, 'public_html')) {
            return $standardPublicPath;
        }

        // Default to standard public path
        return public_path();
    }

    protected function copyDirectory($source, $destination)
    {
        if (!is_dir($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $files = File::allFiles($source);
        $copied = 0;

        foreach ($files as $file) {
            $relativePath = str_replace($source . '/', '', $file->getPathname());
            $destPath = $destination . '/' . $relativePath;
            $destDir = dirname($destPath);

            if (!is_dir($destDir)) {
                File::makeDirectory($destDir, 0755, true);
            }

            File::copy($file->getPathname(), $destPath);
            $copied++;
        }

        $this->info("✓ Copied {$copied} files");
    }
}

