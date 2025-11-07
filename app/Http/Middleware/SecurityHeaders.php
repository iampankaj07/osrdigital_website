<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevent MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Enable XSS protection in older browsers
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Prevent clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Referrer Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Feature Policy / Permissions Policy
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=(), payment=()');

        // Remove X-Powered-By header to prevent information disclosure
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        // HTTPS/HSTS disabled for development - using HTTP only
        // In production, uncomment these lines:
        // if ($request->isSecure()) {
        //     $response->headers->set(
        //         'Strict-Transport-Security',
        //         'max-age=31536000; includeSubDomains; preload'
        //     );
        // }

        // Enhanced Content Security Policy - allow both http and https
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' http://127.0.0.1:5173 https://code.jquery.com https://cdn.jsdelivr.net https://fonts.bunny.net https://cdnjs.cloudflare.com https://www.googletagmanager.com https://www.google-analytics.com https://cdn.tailwindcss.com https://cdn.quilljs.com https://unpkg.com http://code.jquery.com http://fonts.bunny.net http://cdnjs.cloudflare.com; " .
               "style-src 'self' 'unsafe-inline' http://127.0.0.1:5173 https://cdn.jsdelivr.net https://fonts.bunny.net https://cdnjs.cloudflare.com https://fonts.googleapis.com https://cdn.tailwindcss.com https://cdn.quilljs.com https://unpkg.com http://fonts.bunny.net http://cdnjs.cloudflare.com; " .
               "font-src 'self' data: https://fonts.bunny.net https://cdnjs.cloudflare.com https://fonts.gstatic.com http://fonts.bunny.net http://cdnjs.cloudflare.com; " .
               "img-src 'self' data: https: http: blob:; " .
               "frame-src https://www.google.com/maps/ https://maps.google.com/; " .
               "connect-src 'self' http://127.0.0.1:5173 ws://127.0.0.1:5173 http: https:; " .
               "frame-ancestors 'self'; " .
               "base-uri 'self'; " .
               "form-action 'self';";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
