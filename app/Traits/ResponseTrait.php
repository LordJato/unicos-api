<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ResponseTrait
{
    
    public function responseSuccess($data, $message = "Successful"): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'errors' => null
        ], Response::HTTP_OK);
    }

    /**
     * Error response.
     *
     * @param array|object $errors
     * @param string $message
     * @param int $responseCode
     *
     * @return JsonResponse
     */
    public function responseError($errors, $message = "Something went wrong.", int $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
            'errors' => $errors
        ], $responseCode);
    }

    /**
     * Check if a status code is a valid HTTP status code.
     *
     *
     * @param int $statusCode
     * @return bool
     */
    
    public function getStatusCode($statusCode) : int {

        if($statusCode >= Response::HTTP_CONTINUE && $statusCode <= Response::HTTP_NETWORK_AUTHENTICATION_REQUIRED){
            return $statusCode;
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
