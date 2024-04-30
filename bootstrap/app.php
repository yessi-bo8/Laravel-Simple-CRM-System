<?php

use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: 'api/v1',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status'=> 'Request was not successful.',
                    'message' => 'You do not have the right Authorization.',
                    'data' => "",
                ], 403);
            } else {
                return response()->view('errors.error', ['statusCode' => 403, 'message' => 'You do not have the right Authorization.']);
            }
        });
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status'=> 'Request was not successful.',
                    'message' => 'Requested data is not found.',
                    'data' => "",
                ], 404);
            } else {
                return response()->view('errors.error', ['statusCode' => 404, 'message' => 'Requested data is not found.']);
            }
        });
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status'=> 'Request was not successful.',
                    'message' => 'The requested HTTP method is not supported for this resource.',
                    'data' => "",
                ], 404);
            } else {
                return response()->view('errors.error', ['statusCode' => 405, 'message' => 'The requested HTTP method is not supported for this resource.']);
            }
        });
    })->create();
