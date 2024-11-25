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
        // $middleware->use([\App\Http\Middleware\RoleMiddleware::class]); // наш мидлвар роли
        $middleware->alias([
            'isActive' => \App\Http\Middleware\RoleMiddlewareIsActive::class,
            'isAdmin' => \App\Http\Middleware\RoleMiddlewareIsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
