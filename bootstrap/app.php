<?php

use App\Http\Middleware\CheckForMaintenance;
use App\Http\Middleware\RedirectIfNotMaintenance;
use App\Http\Middleware\RoleManager;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'rolemanager' => RoleManager::class,
            'maintenance' => CheckForMaintenance::class,
            'notmaintenance' => RedirectIfNotMaintenance::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
