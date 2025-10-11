<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class TestCloudStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:test-cloud 
                            {--url= : Test specific URL endpoint}
                            {--file= : Test with specific file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test file storage on Laravel Cloud environment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing cloud storage...');
        
        // Test basic storage operations
        $this->testBasicStorage();
        
        // Test file upload simulation
        $this->testFileUpload();
        
        // Test specific URL if provided
        if ($this->option('url')) {
            $this->testUrlEndpoint($this->option('url'));
        }
        
        $this->info('Cloud storage test completed!');
    }
    
    private function testBasicStorage()
    {
        $this->info('Testing basic storage operations...');
        
        try {
            // Test directory creation
            $testDir = 'test-' . time();
            Storage::disk('public')->makeDirectory($testDir);
            
            if (Storage::disk('public')->exists($testDir)) {
                $this->line("✓ Directory creation: {$testDir}");
            } else {
                $this->error("✗ Directory creation failed: {$testDir}");
            }
            
            // Test file storage
            $testFile = $testDir . '/test.txt';
            $testContent = 'Test content for cloud storage';
            Storage::disk('public')->put($testFile, $testContent);
            
            if (Storage::disk('public')->exists($testFile)) {
                $this->line("✓ File storage: {$testFile}");
                
                // Test file reading
                $readContent = Storage::disk('public')->get($testFile);
                if ($readContent === $testContent) {
                    $this->line("✓ File reading: content matches");
                } else {
                    $this->error("✗ File reading: content mismatch");
                }
                
                // Test URL generation
                $url = Storage::disk('public')->url($testFile);
                if (!empty($url)) {
                    $this->line("✓ URL generation: {$url}");
                } else {
                    $this->error("✗ URL generation failed");
                }
                
                // Test file size
                $size = Storage::disk('public')->size($testFile);
                $this->line("✓ File size: {$size} bytes");
                
            } else {
                $this->error("✗ File storage failed: {$testFile}");
            }
            
            // Cleanup
            Storage::disk('public')->deleteDirectory($testDir);
            $this->line("✓ Cleanup completed");
            
        } catch (\Exception $e) {
            $this->error("✗ Basic storage test failed: " . $e->getMessage());
        }
    }
    
    private function testFileUpload()
    {
        $this->info('Testing file upload simulation...');
        
        try {
            // Create a temporary file
            $tempFile = tempnam(sys_get_temp_dir(), 'test_upload');
            file_put_contents($tempFile, 'Test image content for upload');
            
            // Create UploadedFile instance
            $uploadedFile = new UploadedFile(
                $tempFile,
                'test-image.png',
                'image/png',
                null,
                true
            );
            
            // Test file validation
            $this->line("✓ UploadedFile created: " . $uploadedFile->getClientOriginalName());
            $this->line("✓ File size: " . $uploadedFile->getSize() . " bytes");
            $this->line("✓ MIME type: " . $uploadedFile->getMimeType());
            $this->line("✓ Is valid: " . ($uploadedFile->isValid() ? 'Yes' : 'No'));
            
            // Test storage with UploadedFile
            $filename = 'test-uploads/test-' . Str::uuid() . '.png';
            $path = Storage::disk('public')->putFileAs('', $uploadedFile, $filename);
            
            if ($path && Storage::disk('public')->exists($filename)) {
                $this->line("✓ File upload simulation successful: {$filename}");
                $this->line("✓ URL: " . Storage::disk('public')->url($filename));
                
                // Cleanup
                Storage::disk('public')->delete($filename);
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
    
    private function testUrlEndpoint($url)
    {
        $this->info("Testing URL endpoint: {$url}");
        
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get($url);
            
            if ($response->getStatusCode() === 200) {
                $this->line("✓ URL endpoint accessible: {$url}");
                $this->line("✓ Response size: " . strlen($response->getBody()) . " bytes");
            } else {
                $this->error("✗ URL endpoint failed: HTTP " . $response->getStatusCode());
            }
            
        } catch (\Exception $e) {
            $this->error("✗ URL endpoint test failed: " . $e->getMessage());
        }
    }
}
