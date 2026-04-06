<?php

declare(strict_types=1);

use App\Http\Middleware\SecurityHeadersMiddleware;
use App\Http\Middleware\SetLocaleMiddleware;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        $middleware->api(append: [
            SecurityHeadersMiddleware::class,
            SetLocaleMiddleware::class,
        ]);
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(function () {
            return true;
        });

        $exceptions->render(function (QueryException $e) {
            report($e);

            return response()->json([
                'message' => 'A server error occurred. Please try again later.',
            ], 500);
        });

        $exceptions->render(function (\Throwable $e) {
            if ($e instanceof HttpException || $e instanceof \Illuminate\Validation\ValidationException) {
                return null;
            }

            report($e);

            return response()->json([
                'message' => 'A server error occurred. Please try again later.',
            ], 500);
        });
    })->create();
