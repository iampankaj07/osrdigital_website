<?php

namespace App\Http\Middleware;

use App\Helpers\SettingsHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip maintenance mode for admin routes and API routes
        if ($request->is('admin/*') || $request->is('api/*')) {
            return $next($request);
        }

        // Check if maintenance mode is enabled
        if (SettingsHelper::isMaintenanceMode()) {
            // Allow access for authenticated admin users
            if (Auth::check() && Auth::user()->hasRole('Admin')) {
                return $next($request);
            }

            // Show maintenance page for everyone else
            return response()->view('maintenance', [
                'settings' => [
                    'site_name' => SettingsHelper::getSiteName(),
                    'contact' => SettingsHelper::getContactInfo(),
                ]
            ], 503);
        }

        return $next($request);
    }
}
