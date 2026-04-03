<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // keep default middleware configuration; additional middleware aliases
        // or group modifications can be applied here if needed in future.
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Always return JSON for API requests
        $exceptions->shouldRenderJsonWhen(function ($request, $e) {
            return $request->is('api/*') || $request->wantsJson();
        });

        // Authentication exception -> JSON 401
        $exceptions->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        });

        // Throttle exception -> custom JSON 429 message
        $exceptions->renderable(function (\Illuminate\Http\Exceptions\ThrottleRequestsException $e, $request) {
            return response()->json(['message' => 'Too many attempts. Please try again later.'], 429);
        });
    })
    ->create();

// Rate limiters are defined in AppServiceProvider::boot().
