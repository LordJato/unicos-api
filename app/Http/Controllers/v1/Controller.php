<?php

namespace App\Http\Controllers\v1;

use Exception;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

abstract class Controller
{
    use ResponseTrait;
    
    protected  function handleException(Exception $e): JsonResponse
    {
        return $this->responseError([], $e->getMessage(), $this->getStatusCode($e->getCode()));
    }
}
