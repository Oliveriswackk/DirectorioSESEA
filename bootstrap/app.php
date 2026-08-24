<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Middleware\CheckSessionTimeout;
use App\Http\Middleware\CheckCatalogAccess;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Agregamos middleware al grupo 'web'
        $middleware->web(append: [
            CheckSessionTimeout::class,
        ]);

        // Middleware para administración de catálogos
        $middleware->alias([
            'catalogos' => CheckCatalogAccess::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Error 404 (Página no encontrada)
        $exceptions->render(function (NotFoundHttpException $e, $request) {
            return response()->view('errors.custom', [
                'exception' => new \Exception('La página, recurso o registro que buscas no existe o fue eliminado.')
            ], 404);
        });

        // Otro error del sistema (500, fallos de base de datos, etc.)
        $exceptions->render(function (\Throwable $e, $request) {
            return response()->view('errors.custom', [
                'exception' => $e
            ], 500);
        });
    })->create();