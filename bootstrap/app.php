<?php

use App\Http\Middleware\ForceJsonResponseMiddleware;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(SecurityHeaders::class);
        $middleware->api(append: [
            'throttle:60,1',
        ]);
        $middleware->redirectGuestsTo('admin/login');
        $middleware->redirectUsersTo('admin/dashboard');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'code' => 422,
                    'status' => false,
                    'message' => 'Validation errors',
                    'data' => null,
                    'errors' => $e->errors(),
                ], 422);
            }
        });
        $exceptions->render(function (AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'code' => 401,
                    'status' => false,
                    'message' => 'Unauthorized : Token not found or invalid',
                    'data' => null,
                    'errors' => null
                ], 401);
            }
        });

        $exceptions->render(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'code' => 404,
                    'status' => false,
                    'message' => 'Resource not found.',
                    'data' => null,
                    'errors' => null
                ], 404);
            }
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'code' => 405,
                    'status' => false,
                    'message' => 'Method not allowed.',
                    'data' => null,
                    'errors' => null
                ], 405);
            }
        });
    })->create();
