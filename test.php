<?php
// Simple PHP test file for OSR Digital
echo "<h1>🚀 OSR Digital - Server Test</h1>";
echo "<div style='background: #f0f0f0; padding: 20px; border-radius: 10px; margin: 20px 0;'>";

echo "<h2>📊 Server Information</h2>";
echo "<p><strong>PHP Version:</strong> " . PHP_VERSION . "</p>";
echo "<p><strong>Current Directory:</strong> " . getcwd() . "</p>";
echo "<p><strong>Server Software:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "</p>";
echo "<p><strong>Document Root:</strong> " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "</p>";
echo "<p><strong>Request URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'Unknown') . "</p>";
echo "<p><strong>HTTP Host:</strong> " . ($_SERVER['HTTP_HOST'] ?? 'Unknown') . "</p>";

echo "<h2>🔍 File System Check</h2>";

// Test if index.php exists
if (file_exists('index.php')) {
    echo "<p style='color: green;'>✅ index.php exists</p>";
    echo "<p style='font-size: 12px; color: #666;'>Path: " . realpath('index.php') . "</p>";
} else {
    echo "<p style='color: red;'>❌ index.php not found</p>";
}

// Test if .htaccess exists
if (file_exists('.htaccess')) {
    echo "<p style='color: green;'>✅ .htaccess exists</p>";
    echo "<p style='font-size: 12px; color: #666;'>Path: " . realpath('.htaccess') . "</p>";
} else {
    echo "<p style='color: red;'>❌ .htaccess not found</p>";
}

// Test if mod_rewrite is enabled
echo "<h2>⚙️ Apache Modules</h2>";
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "<p style='color: green;'>✅ mod_rewrite is enabled</p>";
    } else {
        echo "<p style='color: red;'>❌ mod_rewrite is not enabled</p>";
    }
    
    // Show other relevant modules
    $relevant_modules = ['mod_rewrite', 'mod_headers', 'mod_expires', 'mod_deflate'];
    echo "<p><strong>Relevant modules:</strong></p><ul>";
    foreach ($relevant_modules as $module) {
        if (in_array($module, $modules)) {
            echo "<li style='color: green;'>✅ $module</li>";
        } else {
            echo "<li style='color: red;'>❌ $module</li>";
        }
    }
    echo "</ul>";
} else {
    echo "<p style='color: orange;'>⚠️ Cannot check Apache modules (not running on Apache)</p>";
}

// Test Laravel files
echo "<h2>🎯 Laravel Application Check</h2>";
if (file_exists('vendor/autoload.php')) {
    echo "<p style='color: green;'>✅ Laravel vendor files exist</p>";
} else {
    echo "<p style='color: red;'>❌ Laravel vendor files not found</p>";
}

if (file_exists('bootstrap/app.php')) {
    echo "<p style='color: green;'>✅ Laravel bootstrap files exist</p>";
} else {
    echo "<p style='color: red;'>❌ Laravel bootstrap files not found</p>";
}

if (file_exists('.env')) {
    echo "<p style='color: green;'>✅ .env file exists</p>";
} else {
    echo "<p style='color: orange;'>⚠️ .env file not found (may need to create)</p>";
}

if (file_exists('storage')) {
    echo "<p style='color: green;'>✅ storage directory exists</p>";
} else {
    echo "<p style='color: red;'>❌ storage directory not found</p>";
}

if (file_exists('public/build')) {
    echo "<p style='color: green;'>✅ public/build directory exists</p>";
} else {
    echo "<p style='color: orange;'>⚠️ public/build directory not found (run npm run build)</p>";
}

// Test if we can include Laravel
echo "<h2>🧪 Laravel Bootstrap Test</h2>";
try {
    if (file_exists('vendor/autoload.php') && file_exists('bootstrap/app.php')) {
        require_once 'vendor/autoload.php';
        echo "<p style='color: green;'>✅ Composer autoloader loaded successfully</p>";
        
        // Try to load Laravel app
        $app = require_once 'bootstrap/app.php';
        echo "<p style='color: green;'>✅ Laravel application bootstrapped successfully</p>";
        echo "<p style='font-size: 12px; color: #666;'>Laravel Version: " . $app->version() . "</p>";
    } else {
        echo "<p style='color: red;'>❌ Cannot test Laravel bootstrap (missing files)</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Laravel bootstrap failed: " . $e->getMessage() . "</p>";
}

echo "</div>";

echo "<h2>🔧 Next Steps</h2>";
echo "<div style='background: #e8f4fd; padding: 15px; border-radius: 5px; border-left: 4px solid #2196F3;'>";
echo "<p><strong>If you see all green checkmarks:</strong> The server is configured correctly. The issue might be with document root or .htaccess processing.</p>";
echo "<p><strong>If you see red X marks:</strong> Fix those issues first before proceeding.</p>";
echo "<p><strong>If Laravel bootstrap fails:</strong> Check your .env file and database connection.</p>";
echo "</div>";

echo "<p style='margin-top: 20px; font-size: 12px; color: #666;'>";
echo "Test completed at: " . date('Y-m-d H:i:s') . "<br>";
echo "Remove this file after testing for security.";
echo "</p>";
?>
