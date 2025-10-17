<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Lomkit\Rest\Http\Middleware\EnforceExpectsJson;
use Illuminate\Routing\Middleware\SubstituteBindings;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Forcer Accept: application/json handling de Lomkit
        // $middleware->append(EnforceExpectsJson::class);

        // groupe api
        $middleware->group('api', [
            EnforceExpectsJson::class,
            SubstituteBindings::class,
        ]);

        // alias utiles
        $middleware->alias([
            'bindings' => SubstituteBindings::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
