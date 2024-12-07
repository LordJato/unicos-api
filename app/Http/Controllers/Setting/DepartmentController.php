<?php

namespace App\Http\Controllers\Setting;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    use ResponseTrait;
    
    public function index(Request $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            return $this->responseSuccess($validated, "Account fetched successfully");
        } catch (Exception $e) {
            return $this->responseError([], $e->getMessage(), $this->getStatusCode($exception->getCode()));
        }
    }

}
