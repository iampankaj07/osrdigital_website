<?php
// Test asset URLs and file existence
echo "<h1>Asset URL Test</h1>";

// Check if we're in the right directory
echo "<p>Current directory: " . __DIR__ . "</p>";
echo "<p>Document root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";

// Check if build directory exists
$buildDir = __DIR__ . '/public/build';
echo "<p>Build directory exists: " . (is_dir($buildDir) ? 'YES' : 'NO') . "</p>";

if (is_dir($buildDir)) {
    echo "<p>Build directory contents:</p><ul>";
    $files = scandir($buildDir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo "<li>" . $file . "</li>";
        }
    }
    echo "</ul>";
}

// Check if assets directory exists
$assetsDir = $buildDir . '/assets';
echo "<p>Assets directory exists: " . (is_dir($assetsDir) ? 'YES' : 'NO') . "</p>";

if (is_dir($assetsDir)) {
    echo "<p>Sample asset files:</p><ul>";
    $assetFiles = array_slice(scandir($assetsDir), 0, 5);
    foreach ($assetFiles as $file) {
        if ($file != '.' && $file != '..') {
            $filePath = $assetsDir . '/' . $file;
            $fileSize = filesize($filePath);
            echo "<li>" . $file . " (" . $fileSize . " bytes)</li>";
        }
    }
    echo "</ul>";
}

// Test asset URLs
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
echo "<p>Base URL: " . $baseUrl . "</p>";

// Test specific asset files
$testAssets = [
    'assets/icons-BNKDixbA.js',
    'assets/vendor-Bzgz95E1.js',
    'assets/Home-Ch6gPf9a.js',
    'assets/MoviePortfolio-CZVM5qMh.js',
    'assets/router-yBCHRFxk.js'
];

echo "<h2>Asset URL Tests</h2>";
foreach ($testAssets as $asset) {
    $url = $baseUrl . '/build/' . $asset;
    $filePath = $buildDir . '/' . $asset;
    
    echo "<p>";
    echo "<strong>" . $asset . ":</strong> ";
    echo "<a href='" . $url . "' target='_blank'>" . $url . "</a> ";
    echo "(File exists: " . (file_exists($filePath) ? 'YES' : 'NO') . ")";
    echo "</p>";
}

// Test manifest.json
$manifestPath = $buildDir . '/manifest.json';
if (file_exists($manifestPath)) {
    echo "<h2>Manifest Test</h2>";
    $manifest = json_decode(file_get_contents($manifestPath), true);
    echo "<p>Manifest loaded: YES</p>";
    echo "<p>Number of entries: " . count($manifest) . "</p>";
    
    // Show first few entries
    echo "<p>First few manifest entries:</p><ul>";
    $count = 0;
    foreach ($manifest as $key => $value) {
        if ($count < 5) {
            echo "<li>" . $key . " -> " . $value['file'] . "</li>";
            $count++;
        }
    }
    echo "</ul>";
} else {
    echo "<p>Manifest file not found!</p>";
}
?>
