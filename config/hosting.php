<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Hosting Environment Detection
    |--------------------------------------------------------------------------
    |
    | This configuration helps detect whether the application is running
    | on localhost or shared hosting and adjusts settings accordingly.
    |
    */

    'environment' => env('HOSTING_ENV', 'auto'), // auto, localhost, shared

    /*
    |--------------------------------------------------------------------------
    | Auto Detection Settings
    |--------------------------------------------------------------------------
    |
    | These settings are used when HOSTING_ENV is set to 'auto' to automatically
    | detect the hosting environment.
    |
    */

    'auto_detection' => [
        'localhost_indicators' => [
            'localhost',
            '127.0.0.1',
            '::1',
            '192.168.',
            '10.0.',
            '172.16.',
            '.test',
            '.local',
            '.localhost',
        ],
        'shared_hosting_indicators' => [
            'cpanel',
            'shared',
            'hosting',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Environment Specific Settings
    |--------------------------------------------------------------------------
    |
    | Different settings for different hosting environments.
    |
    */

    'localhost' => [
        'debug' => true,
        'cache' => false,
        'optimize' => false,
        'asset_url' => null,
        'session_driver' => 'file',
        'cache_driver' => 'file',
    ],

    'shared' => [
        'debug' => false,
        'cache' => true,
        'optimize' => true,
        'asset_url' => env('ASSET_URL'),
        'session_driver' => 'database',
        'cache_driver' => 'database',
    ],

    /*
    |--------------------------------------------------------------------------
    | URL Configuration
    |--------------------------------------------------------------------------
    |
    | URL settings that work for both localhost and shared hosting.
    |
    */

    'urls' => [
        'force_https' => env('FORCE_HTTPS', false),
        'trusted_proxies' => env('TRUSTED_PROXIES', '*'),
    ],

    /*
    |--------------------------------------------------------------------------
    | File Storage Configuration
    |--------------------------------------------------------------------------
    |
    | Storage settings optimized for shared hosting.
    |
    */

    'storage' => [
        'public_disk' => 'local',
        'create_symlink' => true,
        'permissions' => [
            'storage' => 0755,
            'bootstrap_cache' => 0755,
            'public' => 0755,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Performance Settings
    |--------------------------------------------------------------------------
    |
    | Performance optimizations for shared hosting.
    |
    */

    'performance' => [
        'enable_gzip' => true,
        'enable_caching' => true,
        'minify_assets' => true,
        'optimize_autoloader' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Settings
    |--------------------------------------------------------------------------
    |
    | Security settings for shared hosting.
    |
    */

    'security' => [
        'hide_sensitive_files' => true,
        'prevent_directory_browsing' => true,
        'secure_headers' => true,
        'csrf_protection' => true,
    ],
];
