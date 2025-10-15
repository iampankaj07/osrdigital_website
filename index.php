<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Load environment detection helper
require_once __DIR__ . '/env-detector.php';

// Debug environment (remove in production)
debugEnvironment();

// Get environment-specific paths
$paths = getLaravelPaths();

// Determine if the application is in maintenance mode...
if (file_exists($paths['maintenance'])) {
    require $paths['maintenance'];
}

// Register the Composer autoloader...
require $paths['autoload'];

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $paths['bootstrap'];

$app->handleRequest(Request::capture());
