<?php
// Test local development setup
echo "<h1>🧪 Local Development Test - OSR Digital</h1>";

echo "<h2>📊 Environment Check</h2>";
echo "<p><strong>Current URL:</strong> " . ($_SERVER['HTTP_HOST'] ?? 'Unknown') . "</p>";
echo "<p><strong>Document Root:</strong> " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "</p>";
echo "<p><strong>Script Path:</strong> " . __FILE__ . "</p>";
echo "<p><strong>Current Directory:</strong> " . getcwd() . "</p>";

echo "<h2>🔍 File Check</h2>";

// Check if we're in the right directory
$expected_files = [
    'index.php' => 'Main entry point',
    'vendor/autoload.php' => 'Composer autoloader',
    'bootstrap/app.php' => 'Laravel bootstrap',
    'app' => 'Application directory',
    'public' => 'Public directory',
    '.env' => 'Environment file'
];

foreach ($expected_files as $file => $description) {
    if (file_exists($file)) {
        echo "<p style='color: green;'>✅ $description exists</p>";
    } else {
        echo "<p style='color: red;'>❌ $description missing</p>";
    }
}

echo "<h2>🧪 Laravel Test</h2>";

try {
    // Test Composer autoloader
    if (file_exists('vendor/autoload.php')) {
        require_once 'vendor/autoload.php';
        echo "<p style='color: green;'>✅ Composer autoloader loaded</p>";
        
        // Test Laravel bootstrap
        if (file_exists('bootstrap/app.php')) {
            $app = require_once 'bootstrap/app.php';
            echo "<p style='color: green;'>✅ Laravel application created</p>";
            echo "<p style='font-size: 12px; color: #666;'>Laravel Version: " . $app->version() . "</p>";
            echo "<p style='font-size: 12px; color: #666;'>Environment: " . $app->environment() . "</p>";
        } else {
            echo "<p style='color: red;'>❌ Laravel bootstrap file missing</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Composer autoloader missing</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<h2>🔧 Recommendations</h2>";

// Check if we're in the right setup
if (file_exists('public/index.php')) {
    echo "<div style='background: #d1ecf1; padding: 15px; border-radius: 5px; border-left: 4px solid #17a2b8;'>";
    echo "<p><strong>For Local Development:</strong></p>";
    echo "<p>You should use the public folder setup:</p>";
    echo "<ul>";
    echo "<li>Point your local server to the <code>public/</code> folder</li>";
    echo "<li>Access via: <code>http://osr.test/</code> or <code>http://localhost:8000/</code></li>";
    echo "<li>Use: <code>php artisan serve</code> for development</li>";
    echo "</ul>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; border-left: 4px solid #dc3545;'>";
    echo "<p><strong>Issue Found:</strong></p>";
    echo "<p>The public/index.php file is missing. This is required for local development.</p>";
    echo "</div>";
}

echo "<p style='margin-top: 20px; font-size: 12px; color: #666;'>";
echo "Test completed at: " . date('Y-m-d H:i:s');
echo "</p>";
?>
