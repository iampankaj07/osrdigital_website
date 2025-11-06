<?php

/**
 * Security Configuration for OSR Digital
 *
 * This file contains comprehensive security configurations including:
 * - CORS policies
 * - Rate limiting
 * - Input validation
 * - Authentication security
 * - API security
 */

return [
    /*
    |--------------------------------------------------------------------------
    | CORS Configuration
    |--------------------------------------------------------------------------
    |
    | Configure Cross-Origin Resource Sharing policies
    |
    */
    'cors' => [
        'allowed_origins' => [
            'http://osr.test',
            'http://localhost:3000',
            'http://localhost:8000',
            // Add production domain
        ],
        'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
        'allowed_headers' => ['Content-Type', 'Authorization', 'X-Requested-With'],
        'max_age' => 86400,
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting Configuration
    |--------------------------------------------------------------------------
    |
    | Configure rate limits to prevent abuse and DDoS attacks
    |
    */
    'rate_limiting' => [
        'api' => [
            'limit' => 60,  // 60 requests
            'period' => 60, // per minute
        ],
        'login' => [
            'limit' => 5,   // 5 attempts
            'period' => 900, // per 15 minutes
        ],
        'contact_form' => [
            'limit' => 3,   // 3 submissions
            'period' => 3600, // per hour
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | CSRF Protection
    |--------------------------------------------------------------------------
    |
    | Configure CSRF (Cross-Site Request Forgery) protection
    |
    */
    'csrf' => [
        'enabled' => true,
        'token_name' => 'XSRF-TOKEN',
        'cookie_name' => 'XSRF-TOKEN',
        'header_name' => 'X-CSRF-TOKEN',
    ],

    /*
    |--------------------------------------------------------------------------
    | Session Security
    |--------------------------------------------------------------------------
    |
    | Configure session security settings
    |
    */
    'session' => [
        'secure' => env('APP_ENV') === 'production', // HTTPS only in production
        'http_only' => true,  // Prevent JS access to session cookie
        'same_site' => 'Lax', // SameSite cookie attribute
        'lifetime' => 120,    // Session lifetime in minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Security
    |--------------------------------------------------------------------------
    |
    | Configure password strength requirements
    |
    */
    'password' => [
        'min_length' => 12,
        'require_uppercase' => true,
        'require_numbers' => true,
        'require_special_chars' => true,
        'special_chars' => '!@#$%^&*()_+-=[]{}|;:,.<>?',
    ],

    /*
    |--------------------------------------------------------------------------
    | Input Validation Rules
    |--------------------------------------------------------------------------
    |
    | Security-focused input validation rules
    |
    */
    'validation' => [
        'email' => 'required|email|max:255',
        'password' => 'required|string|min:12|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/',
        'url' => 'required|url|max:2000',
        'file_max_size' => 10485760, // 10MB in bytes
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Security
    |--------------------------------------------------------------------------
    |
    | Additional security for admin panel
    |
    */
    'admin' => [
        'enable_ip_whitelist' => false,
        'ip_whitelist' => [],
        'require_2fa' => false,
        'session_timeout' => 30, // minutes
        'failed_login_attempts' => 5,
        'lockout_duration' => 900, // seconds
    ],

    /*
    |--------------------------------------------------------------------------
    | API Security
    |--------------------------------------------------------------------------
    |
    | API endpoint security configuration
    |
    */
    'api' => [
        'require_api_key' => false,
        'api_key_header' => 'X-API-Key',
        'api_key_length' => 32,
        'enable_request_signing' => false,
        'enable_response_encryption' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Security
    |--------------------------------------------------------------------------
    |
    | Configure file upload restrictions and validation
    |
    */
    'file_upload' => [
        'max_size' => 10485760, // 10MB
        'allowed_mime_types' => [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ],
        'scan_for_malware' => false,
        'quarantine_path' => storage_path('app/quarantine'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Audit Logging
    |--------------------------------------------------------------------------
    |
    | Enable and configure audit logging for security events
    |
    */
    'audit_logging' => [
        'enabled' => true,
        'log_failed_logins' => true,
        'log_password_changes' => true,
        'log_permission_changes' => true,
        'log_api_requests' => false,
        'retention_days' => 90,
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Headers
    |--------------------------------------------------------------------------
    |
    | Configure HTTP security headers
    |
    */
    'headers' => [
        'X-Content-Type-Options' => 'nosniff',
        'X-Frame-Options' => 'SAMEORIGIN',
        'X-XSS-Protection' => '1; mode=block',
        'Referrer-Policy' => 'strict-origin-when-cross-origin',
        'Permissions-Policy' => 'geolocation=(), microphone=(), camera=(), payment=()',
    ],

    /*
    |--------------------------------------------------------------------------
    | Encryption
    |--------------------------------------------------------------------------
    |
    | Encryption configuration for sensitive data
    |
    */
    'encryption' => [
        'enabled' => true,
        'algorithm' => 'AES-256-GCM',
        'hash_algorithm' => 'sha256',
    ],
];
