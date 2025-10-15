<?php
// Simple PHP test file
echo "<h1>PHP is working!</h1>";
echo "<p>PHP Version: " . PHP_VERSION . "</p>";
echo "<p>Current Directory: " . getcwd() . "</p>";
echo "<p>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Request URI: " . $_SERVER['REQUEST_URI'] . "</p>";

// Test if index.php exists
if (file_exists('index.php')) {
    echo "<p style='color: green;'>✅ index.php exists</p>";
} else {
    echo "<p style='color: red;'>❌ index.php not found</p>";
}

// Test if .htaccess exists
if (file_exists('.htaccess')) {
    echo "<p style='color: green;'>✅ .htaccess exists</p>";
} else {
    echo "<p style='color: red;'>❌ .htaccess not found</p>";
}

// Test if mod_rewrite is enabled
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "<p style='color: green;'>✅ mod_rewrite is enabled</p>";
    } else {
        echo "<p style='color: red;'>❌ mod_rewrite is not enabled</p>";
    }
} else {
    echo "<p style='color: orange;'>⚠️ Cannot check mod_rewrite status</p>";
}

// Test Laravel files
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
?>
