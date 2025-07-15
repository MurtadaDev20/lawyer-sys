<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\EnsureLawyerIsVerify;
use App\Http\Middleware\EnsureCustomerIsVerify;
use App\Http\Middleware\EnsureEdaraIsAuthenticated;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'EnsureCustomerIsVerify' => EnsureCustomerIsVerify::class,
            'EnsureLawyerIsVerify' => EnsureLawyerIsVerify::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
