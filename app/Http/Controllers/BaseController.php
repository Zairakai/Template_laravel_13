<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;

abstract class BaseController extends Controller
{
    /**
     * Return an error response in JSON format.
     */
    public function errorResponse(
        string $message,
        int $statusCode = 400,
    ): JsonResponse {
        return response()
            ->json(
                [
                    'status'  => 'error',
                    'message' => $message,
                ],
                $statusCode,
            );
    }

    /**
     * Handle an exception and return a standardized error response.
     */
    public function handleException(
        Exception $exception,
        string $message = 'An error occurred',
    ): JsonResponse {
        Log::error(
            $exception->getMessage(),
            ['exception' => $exception],
        );

        return $this->errorResponse($message, 500);
    }

    /**
     * Return paginated data in a consistent JSON format.
     * Accepts a ResourceCollection (wrapping a paginator) or a raw LengthAwarePaginator.
     *
     * @param ResourceCollection<int, JsonResource>|LengthAwarePaginator<int, Model> $data
     */
    public function paginatedResponse(
        ResourceCollection|LengthAwarePaginator $data,
        string $message = 'Success',
    ): JsonResponse {
        /** @var LengthAwarePaginator<int, Model> $paginator */
        $paginator = $data instanceof ResourceCollection
            ? $data->resource
            : $data;

        return response()
            ->json(
                [
                    'status'  => 'success',
                    'message' => $message,
                    'data'    => $data instanceof ResourceCollection
                        ? $data->resolve()
                        : $paginator->items(),
                    'pagination' => [
                        'current_page' => $paginator->currentPage(),
                        'total_pages'  => $paginator->lastPage(),
                        'total_items'  => $paginator->total(),
                        'per_page'     => $paginator->perPage(),
                    ],
                ],
            );
    }

    /**
     * Return a success response in JSON format.
     * Prefer a JsonResource for structured responses — raw arrays log a deprecation warning.
     */
    public function successResponse(
        JsonResource|array|null $data = null,
        string $message = 'Success',
        int $statusCode = 200,
    ): JsonResponse {
        if (is_array($data)) {
            $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1] ?? [];

            $class    = $caller['class']    ?? static::class;
            $function = $caller['function'] ?? 'unknown';
            $line     = isset($caller['line'])
                ? " (L{$caller['line']})"
                : '';

            Log::warning("Prefer a JsonResource over a raw array in {$class}::{$function}(){$line}.");
        }

        return response()
            ->json(
                [
                    'status'  => 'success',
                    'message' => $message,
                    'data'    => $data instanceof JsonResource
                        ? $data->resolve()
                        : $data,
                ],
                $statusCode,
            );
    }
}
