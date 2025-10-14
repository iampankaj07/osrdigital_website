<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*',
        'upload/*',
        'admin/*/upload',
        'admin/film-portfolios/upload',
        'admin/testimonials/upload',
        'admin/media/upload',
        'admin/media/revert',
    ];

    /**
     * Determine if the request has a URI that should pass through CSRF verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        // Always exclude API routes
        if (str_starts_with($request->path(), 'api/')) {
            return true;
        }

        return parent::inExceptArray($request);
    }
}
