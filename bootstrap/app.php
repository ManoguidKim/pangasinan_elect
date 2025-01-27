<?php

use App\Http\Middleware\AdminEncoderMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AdminScannerMiddleware;
use App\Http\Middleware\AdminValidatorMiddleware;
use App\Http\Middleware\EncoderMiddleware;
use App\Http\Middleware\SuperAdminAdminMiddleware;
use App\Http\Middleware\SuperAdminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'isAdmin' => AdminMiddleware::class,
            'isAdminEncoder' => AdminEncoderMiddleware::class,
            'isAdminValidator' => AdminValidatorMiddleware::class,
            'isAdminScanner' => AdminScannerMiddleware::class,

            'isSuperAdmin' => SuperAdminMiddleware::class,
            'isSuperAdminAdmin' => SuperAdminAdminMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
