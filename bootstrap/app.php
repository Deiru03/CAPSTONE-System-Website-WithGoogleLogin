<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RedirectIfNotAdmin;
use App\Http\Middleware\RedirectIfNotFaculty;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register Middleware
        $middleware->alias([
            'Admin' => \App\Http\Middleware\RedirectIfNotAdmin::class,
            'Dean' => \App\Http\Middleware\RedirectIfNotAdmin::class,
            'Program-Head' => \App\Http\Middleware\RedirectIfNotAdmin::class,
            'Faculty' => \App\Http\Middleware\RedirectIfNotFaculty::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
