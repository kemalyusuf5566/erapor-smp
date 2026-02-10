<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        /*
        |--------------------------------------------------------------------------
        | Middleware Alias (Laravel 12)
        |--------------------------------------------------------------------------
        | Semua alias middleware didaftarkan di sini
        */

        $middleware->alias([
            'roleaccess'   => \App\Http\Middleware\RoleAccess::class,
            'guru.context' => \App\Http\Middleware\GuruContext::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
