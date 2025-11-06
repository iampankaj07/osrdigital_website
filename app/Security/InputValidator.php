<?php

namespace App\Security;

use Illuminate\Support\Facades\Validator;

class InputValidator
{
    /**
     * Validate input for common security issues
     */
    public static function validateSecure(array $data, array $rules = []): array
    {
        // Sanitize inputs
        $sanitized = self::sanitizeInputs($data);

        // Validate
        if (!empty($rules)) {
            Validator::make($sanitized, $rules)->validate();
        }

        return $sanitized;
    }

    /**
     * Sanitize user inputs to prevent XSS and injection attacks
     */
    public static function sanitizeInputs(array $inputs): array
    {
        $sanitized = [];

        foreach ($inputs as $key => $value) {
            if (is_string($value)) {
                $sanitized[$key] = self::sanitizeString($value);
            } elseif (is_array($value)) {
                $sanitized[$key] = self::sanitizeInputs($value);
            } else {
                $sanitized[$key] = $value;
            }
        }

        return $sanitized;
    }

    /**
     * Sanitize a string value
     */
    public static function sanitizeString(string $value): string
    {
        // Remove null bytes
        $value = str_replace("\0", '', $value);

        // HTML encode (but preserve some allowed tags)
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

        // Remove any script tags or javascript protocols
        $value = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $value);
        $value = preg_replace('/javascript:/i', '', $value);
        $value = preg_replace('/on\w+\s*=/i', '', $value);

        return trim($value);
    }

    /**
     * Validate email
     */
    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate URL
     */
    public static function validateUrl(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Validate password strength
     */
    public static function validatePasswordStrength(string $password): array
    {
        $errors = [];
        $config = config('security.password');

        if (strlen($password) < ($config['min_length'] ?? 12)) {
            $errors[] = "Password must be at least {$config['min_length']} characters long";
        }

        if ($config['require_uppercase'] && !preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain at least one uppercase letter';
        }

        if ($config['require_numbers'] && !preg_match('/\d/', $password)) {
            $errors[] = 'Password must contain at least one number';
        }

        if ($config['require_special_chars'] && !preg_match('/[' . preg_quote($config['special_chars'], '/') . ']/', $password)) {
            $errors[] = 'Password must contain at least one special character';
        }

        return $errors;
    }

    /**
     * Validate file upload
     */
    public static function validateFileUpload($file): array
    {
        $errors = [];
        $config = config('security.file_upload');

        if (!$file) {
            $errors[] = 'No file uploaded';
            return $errors;
        }

        // Check file size
        if ($file->getSize() > ($config['max_size'] ?? 10485760)) {
            $errors[] = 'File size exceeds maximum allowed size';
        }

        // Check MIME type
        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, $config['allowed_mime_types'] ?? [])) {
            $errors[] = 'File type not allowed';
        }

        // Check file extension
        $extension = $file->getClientOriginalExtension();
        if (!in_array(strtolower($extension), config('security.validation.allowed_extensions', []))) {
            $errors[] = 'File extension not allowed';
        }

        return $errors;
    }
}
