<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Repositories\AuthRepository;
use App\Http\Repositories\TokenRepository;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;

class AuthController extends Controller
{
    use ResponseTrait;

    private const REFRESH_TOKEN_EXPIRY = 60 * 24 * 30; // 30 days

    public function __construct(
        private readonly AuthRepository $authRepository,
        private readonly TokenRepository $tokenRepository
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $data = $this->authRepository->login($validatedData);
            if ($data) {
                $credentials = [
                    'email' => $validatedData['email'],
                    'password' => $validatedData['password']
                ];
                $token = $this->tokenRepository->generateAccessToken($credentials);
            }
            return $this->responseSuccess($token, 'Logged in successfully.')
                ->cookie('refresh_token', $token['refresh_token'], self::REFRESH_TOKEN_EXPIRY, null, null, true, true);
        } catch (Exception $e) {

            return $this->handleException($e);
        }
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {

            $data = $this->authRepository->register($request->all());

            return $this->responseSuccess($data, 'User registered successfully.');
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function logout(): JsonResponse
    {
        try {

            $this->authRepository->logout();

            return $this->responseSuccess('', 'User logged out successfully !')->cookie('refresh_token', '', -1);
        } catch (Exception $e) {

            return $this->handleException($e);
        }
    }


    public function newAccessToken(Request $request): JsonResponse
    {
        try {
            $refreshToken = $request->cookie('refresh_token');

            $token = $this->tokenRepository->refreshAccessToken($refreshToken);

            return $this->responseSuccess($token, 'New access token acquired.')
                ->cookie('refresh_token', $token['refresh_token'], self::REFRESH_TOKEN_EXPIRY, null, null, true, true);
        } catch (Exception $e) {

            return $this->handleException($e);
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $data = $this->authRepository->forgotPassword($request->only('email'));

            return $this->responseSuccess($data, 'Email sent');
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $data = $this->authRepository->resetPassword($request->all());

            return $this->responseSuccess($data, 'Password Reset Successfully');
        } catch (Exception $e) {

            return $this->handleException($e);
        }
    }

    private function handleException(Exception $e): JsonResponse
    {
        return $this->responseError([], $e->getMessage(), $this->getStatusCode($e->getCode()));
    }
}
