<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiRateLimit
{
    /**
     * The rate limiter instance.
     */
    protected RateLimiter $limiter;

    /**
     * Create a new middleware instance.
     */
    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = $this->resolveRequestSignature($request);
        $limit = config('security.rate_limiting.api.limit', 60);
        $period = config('security.rate_limiting.api.period', 60);

        if ($this->limiter->tooManyAttempts($key, $limit)) {
            return response()->json([
                'success' => false,
                'message' => 'Rate limit exceeded. Please try again later.',
            ], 429)->header('Retry-After', $this->limiter->availableIn($key));
        }

        $this->limiter->hit($key, $period);

        return $next($request)->header('X-RateLimit-Limit', $limit)
            ->header('X-RateLimit-Remaining', $limit - $this->limiter->attempts($key))
            ->header('X-RateLimit-Reset', $this->limiter->availableIn($key));
    }

    /**
     * Resolve request signature for rate limiting.
     */
    protected function resolveRequestSignature(Request $request): string
    {
        return sha1(implode('|', [
            $request->method(),
            $request->getHost(),
            $request->ip(),
        ]));
    }
}
