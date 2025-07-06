<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Add CSRF exceptions for SSLCOMMERZ payment callbacks
        $middleware->validateCsrfTokens(except: [
            '/payment/success',
            '/payment/fail',
            '/payment/cancel',
            '/payment/ipn',
            '/pay-via-ajax',
        ]);

        // Register custom middleware
        $middleware->alias([
            'prevent.cross.access' => \App\Http\Middleware\PreventCrossUserAccess::class,
            'restrict.author.access' => \App\Http\Middleware\RestrictAuthorAccess::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
