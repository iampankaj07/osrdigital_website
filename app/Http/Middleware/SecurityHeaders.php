<?php

namespace App\Http\Middleware;

use App\Helpers\HostingHelper;
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
        // Check if we're in local/development environment
        $isLocal = app()->isLocal() || HostingHelper::isLocalhost();
        
        // Redirect HTTPS to HTTP for localhost/development
        if ($request->isSecure() && $isLocal) {
            return redirect('http://' . $request->getHttpHost() . $request->getRequestUri(), 301);
        }

        // Force HTTPS in production (redirect HTTP to HTTPS)
        if (!$request->isSecure() && !$isLocal) {
            return redirect('https://' . $request->getHttpHost() . $request->getRequestUri(), 301);
        }

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

        // Clear HSTS for localhost/development, enable for production
        $isLocal = app()->isLocal() || HostingHelper::isLocalhost();
        if ($isLocal) {
            // Clear HSTS cache for localhost domains
            $response->headers->set('Strict-Transport-Security', 'max-age=0');
        } elseif ($request->isSecure()) {
            // Enable HSTS in production (HTTPS only)
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains; preload'
            );
        }

        // Enhanced Content Security Policy
        if ($isLocal) {
            // More permissive CSP for localhost/development (allows Vite dev server and admin CDNs)
            // Note: CSP doesn't support IPv6 addresses, so we only use IPv4 localhost
            $csp = "default-src 'self'; " .
                   "script-src 'self' 'unsafe-inline' 'unsafe-eval' http://localhost:5173 http://localhost:5174 http://127.0.0.1:5173 http://127.0.0.1:5174 https://cdn.tailwindcss.com https://cdn.jsdelivr.net https://code.jquery.com https://cdn.quilljs.com https://fonts.googleapis.com https://fonts.bunny.net https://cdnjs.cloudflare.com https://www.googletagmanager.com https://www.google-analytics.com http://fonts.bunny.net http://cdnjs.cloudflare.com; " .
                   "style-src 'self' 'unsafe-inline' http://localhost:5173 http://localhost:5174 http://127.0.0.1:5173 http://127.0.0.1:5174 https://cdn.tailwindcss.com https://cdn.jsdelivr.net https://cdn.quilljs.com https://fonts.googleapis.com https://fonts.bunny.net https://cdnjs.cloudflare.com http://fonts.bunny.net http://cdnjs.cloudflare.com; " .
                   "font-src 'self' data: https://fonts.googleapis.com https://fonts.gstatic.com https://fonts.bunny.net https://cdnjs.cloudflare.com http://fonts.bunny.net http://cdnjs.cloudflare.com; " .
                   "img-src 'self' data: https: http: blob:; " .
                   "connect-src 'self' http://localhost:5173 http://localhost:5174 http://127.0.0.1:5173 http://127.0.0.1:5174 ws://localhost:5173 ws://localhost:5174 ws://127.0.0.1:5173 ws://127.0.0.1:5174 http: https:; " .
                   "frame-ancestors 'self'; " .
                   "base-uri 'self'; " .
                   "form-action 'self';";
        } else {
            // Production CSP (includes admin CDNs)
        $csp = "default-src 'self'; " .
                   "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com https://cdn.jsdelivr.net https://code.jquery.com https://cdn.quilljs.com https://fonts.googleapis.com https://fonts.bunny.net https://cdnjs.cloudflare.com https://www.googletagmanager.com https://www.google-analytics.com http://fonts.bunny.net http://cdnjs.cloudflare.com; " .
                   "style-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com https://cdn.jsdelivr.net https://cdn.quilljs.com https://fonts.googleapis.com https://fonts.bunny.net https://cdnjs.cloudflare.com http://fonts.bunny.net http://cdnjs.cloudflare.com; " .
                   "font-src 'self' data: https://fonts.googleapis.com https://fonts.gstatic.com https://fonts.bunny.net https://cdnjs.cloudflare.com http://fonts.bunny.net http://cdnjs.cloudflare.com; " .
               "img-src 'self' data: https: http: blob:; " .
               "connect-src 'self' http: https:; " .
               "frame-ancestors 'self'; " .
               "base-uri 'self'; " .
               "form-action 'self';";
        }

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
