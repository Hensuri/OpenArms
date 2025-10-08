<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class LoginRateLimiter
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $key = 'login.' . $request->ip();
        
        if ($this->limiter->tooManyAttempts($key, 5)) { // 5 attempts max
            $seconds = $this->limiter->availableIn($key);
            return response()->json([
                'error' => 'Too many login attempts. Please try again in ' . $seconds . ' seconds.'
            ], 429);
        }

        $this->limiter->hit($key, 300); // Reset after 5 minutes

        return $next($request);
    }
}