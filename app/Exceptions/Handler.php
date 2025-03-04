<?php

namespace App\Exceptions;

use App\Traits\ResponseTrait;
use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    use ResponseTrait;

    public function render($request, Throwable $exception)
    {
        // Determine the status code
        $status = $exception instanceof HttpException
            ? $exception->getStatusCode()
            : Response::HTTP_INTERNAL_SERVER_ERROR;

        // Use responseError() from ResponseTrait
        return $this->responseError(
            null,
            $exception->getMessage(),
            $this->getStatusCode($status)
        );
    }
}
