<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CloudDebugController extends Controller
{
    /**
     * Debug cloud storage status
     */
    public function debugStorage(Request $request)
    {
        try {
            $debugInfo = [
                'timestamp' => now()->toISOString(),
                'environment' => app()->environment(),
                'filesystem_config' => [
                    'default_disk' => config('filesystems.default'),
                    'public_disk_root' => config('filesystems.disks.public.root'),
                    'public_disk_url' => config('filesystems.disks.public.url'),
                ],
                'storage_paths' => [
                    'storage_path' => storage_path('app/public'),
                    'storage_exists' => is_dir(storage_path('app/public')),
                    'storage_writable' => is_writable(storage_path('app/public')),
                ],
                'directories' => [
                    'associates_exists' => Storage::disk('public')->exists('associates'),
                    'associates_writable' => is_writable(storage_path('app/public/associates')),
                ],
                'test_operations' => []
            ];
            
            // Test basic storage operations
            try {
                $testFile = 'debug-test-' . time() . '.txt';
                $testContent = 'Debug test content';
                
                // Test write
                Storage::disk('public')->put($testFile, $testContent);
                $debugInfo['test_operations']['write'] = 'success';
                
                // Test read
                $readContent = Storage::disk('public')->get($testFile);
                $debugInfo['test_operations']['read'] = $readContent === $testContent ? 'success' : 'failed';
                
                // Test exists
                $debugInfo['test_operations']['exists'] = Storage::disk('public')->exists($testFile) ? 'success' : 'failed';
                
                // Test URL
                $url = Storage::disk('public')->url($testFile);
                $debugInfo['test_operations']['url'] = !empty($url) ? 'success' : 'failed';
                $debugInfo['test_operations']['url_value'] = $url;
                
                // Test size
                $size = Storage::disk('public')->size($testFile);
                $debugInfo['test_operations']['size'] = $size;
                
                // Cleanup
                Storage::disk('public')->delete($testFile);
                $debugInfo['test_operations']['cleanup'] = 'success';
                
            } catch (\Exception $e) {
                $debugInfo['test_operations']['error'] = $e->getMessage();
            }
            
            // Test directory operations
            try {
                $testDir = 'debug-test-dir-' . time();
                Storage::disk('public')->makeDirectory($testDir);
                $debugInfo['test_operations']['directory_creation'] = Storage::disk('public')->exists($testDir) ? 'success' : 'failed';
                
                // Cleanup
                Storage::disk('public')->deleteDirectory($testDir);
                $debugInfo['test_operations']['directory_cleanup'] = 'success';
                
            } catch (\Exception $e) {
                $debugInfo['test_operations']['directory_error'] = $e->getMessage();
            }
            
            // Get recent logs
            $debugInfo['recent_logs'] = $this->getRecentLogs();
            
            return response()->json([
                'success' => true,
                'debug_info' => $debugInfo
            ]);
            
        } catch (\Exception $e) {
            Log::error('Cloud debug error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
    
    /**
     * Get recent log entries related to file uploads
     */
    private function getRecentLogs()
    {
        try {
            $logFile = storage_path('logs/laravel.log');
            if (!file_exists($logFile)) {
                return ['error' => 'Log file not found'];
            }
            
            $logs = [];
            $lines = file($logFile, FILE_IGNORE_NEW_LINES);
            $recentLines = array_slice($lines, -50); // Last 50 lines
            
            foreach ($recentLines as $line) {
                if (strpos($line, 'associate') !== false || 
                    strpos($line, 'upload') !== false || 
                    strpos($line, 'storage') !== false) {
                    $logs[] = $line;
                }
            }
            
            return array_slice($logs, -10); // Last 10 relevant lines
            
        } catch (\Exception $e) {
            return ['error' => 'Failed to read logs: ' . $e->getMessage()];
        }
    }
}
