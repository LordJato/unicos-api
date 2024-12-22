<?php

namespace App\Http\Controllers;

use Exception;
use App\Traits\ResponseTrait;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Repositories\AuthRepository;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;

class AuthController extends Controller
{
    use ResponseTrait;

    public function __construct(private AuthRepository $auth,)
    {
        $this->auth = $auth;
    }

    public function login(LoginRequest $request)
    {
        try {
            $data = $this->auth->login($request->all());

            return $this->responseSuccess($data, 'Logged in successfully.')
            ->cookie('refresh_token', $data['refresh_token'], 60 * 24 * 30, null, null, true, true); // HttpOnly cookie;

        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $this->getStatusCode($exception->getCode()));
        }
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {

            $data = $this->auth->register($request->all());

            return $this->responseSuccess($data, 'User registered successfully.');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $this->getStatusCode($exception->getCode()));
        }
    }

    public function logout(): JsonResponse
    {
        try {
            
            $this->auth->logout();

            return $this->responseSuccess('', 'User logged out successfully !')->cookie('refresh_token', '', -1);

        } catch (Exception $exception) {
            
            return $this->responseError([], $exception->getMessage(), $this->getStatusCode($exception->getCode()));
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $data = $this->auth->forgotPassword($request->only('email'));

            return $this->responseSuccess($data, 'Email sent');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $data = $this->auth->resetPassword($request->all());

            return $this->responseSuccess($data, 'Password Reset Successfully');
        } catch (Exception $exception) {

            return $this->responseError([], $exception->getMessage(), $exception->getCode());
        }
    }
}
