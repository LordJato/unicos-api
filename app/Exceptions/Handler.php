<?php
namespace App\Exceptions;

use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception): JsonResponse
    {
        return response()->json([
            'message' => $exception->getMessage(),
            'status' => $exception->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR,
        ], $exception->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
