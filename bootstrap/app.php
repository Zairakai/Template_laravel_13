<?php

declare(strict_types=1);

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {})
    ->withExceptions(function (Exceptions $exceptions) {
        $json = static fn (Request $request): bool => $request->expectsJson()
            || $request->is('api/*');

        $exceptions->render(function (AuthenticationException $e, Request $request) use ($json): ?JsonResponse {
            if (! $json($request)) {
                return null;
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated.',
            ], JsonResponse::HTTP_UNAUTHORIZED);
        });

        $exceptions->render(function (AuthorizationException $e, Request $request) use ($json): ?JsonResponse {
            if (! $json($request)) {
                return null;
            }

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'This action is unauthorized.',
            ], JsonResponse::HTTP_FORBIDDEN);
        });

        $exceptions->render(function (ModelNotFoundException|NotFoundHttpException $e, Request $request) use ($json): ?JsonResponse {
            if (! $json($request)) {
                return null;
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Resource not found.',
            ], JsonResponse::HTTP_NOT_FOUND);
        });

        $exceptions->render(function (ValidationException $e, Request $request) use ($json): ?JsonResponse {
            if (! $json($request)) {
                return null;
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        });

        $exceptions->render(function (HttpException $e, Request $request) use ($json): ?JsonResponse {
            if (! $json($request)) {
                return null;
            }

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage() ?: 'An HTTP error occurred.',
            ], $e->getStatusCode());
        });
    })
    ->create();
