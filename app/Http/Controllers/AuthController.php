<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Repositories\AuthRepository;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    use ResponseTrait;

    public function __construct(private AuthRepository $auth, )
    {
        $this->auth = $auth;
    }

    public function login(LoginRequest $request)
    {
        try {
            $data = $this->auth->login($request->all()); 

            return $this->responseSuccess($data, 'Logged in successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage());
        }
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $data = $this->auth->register($request->all());

            return $this->responseSuccess($data, 'User registered successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage());
        }
    }
}
