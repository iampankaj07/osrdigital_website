<?php
/**
 * Environment Detection Helper
 * Detects if running locally or on subdomain and adjusts paths accordingly
 */

function detectEnvironment() {
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $isLocal = in_array($host, ['localhost', '127.0.0.1', 'osr.test']) || 
               strpos($host, 'localhost') !== false ||
               strpos($host, '127.0.0.1') !== false ||
               strpos($host, '.test') !== false ||
               strpos($host, '.local') !== false;
    
    return [
        'is_local' => $isLocal,
        'is_subdomain' => !$isLocal,
        'host' => $host,
        'base_path' => $isLocal ? __DIR__ : __DIR__,
        'public_path' => $isLocal ? __DIR__ . '/public' : __DIR__ . '/public'
    ];
}

function getLaravelPaths() {
    $env = detectEnvironment();
    
    return [
        'maintenance' => $env['base_path'] . '/storage/framework/maintenance.php',
        'autoload' => $env['base_path'] . '/vendor/autoload.php',
        'bootstrap' => $env['base_path'] . '/bootstrap/app.php'
    ];
}

// Debug function (remove in production)
function debugEnvironment() {
    if (isset($_GET['debug']) && $_GET['debug'] === 'env') {
        $env = detectEnvironment();
        $paths = getLaravelPaths();
        
        echo "<h2>Environment Debug</h2>";
        echo "<pre>";
        echo "Environment: " . json_encode($env, JSON_PRETTY_PRINT) . "\n";
        echo "Paths: " . json_encode($paths, JSON_PRETTY_PRINT) . "\n";
        echo "Files exist:\n";
        foreach ($paths as $name => $path) {
            echo "  $name: " . (file_exists($path) ? 'YES' : 'NO') . " ($path)\n";
        }
        echo "</pre>";
        exit;
    }
}
