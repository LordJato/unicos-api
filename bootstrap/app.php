<?php

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use Illuminate\Foundation\Application;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $handler = new class {
            use ResponseTrait;
        };

        $exceptions->render(function (NotFoundHttpException $e, Request $request) use ($handler) {
            if ($request->is('api/*')) {
                return $handler->responseError([], $e->getMessage(), Response::HTTP_NOT_FOUND);
            }
        });

        $exceptions->render(function (UnauthorizedHttpException|AuthorizationException|AccessDeniedHttpException $e, Request $request) use ($handler) {
            if ($request->is('api/*')) {
                return $handler->responseError([], $e->getMessage(), Response::HTTP_FORBIDDEN);
            }
        });

    })->create();
