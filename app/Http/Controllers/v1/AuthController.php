<?php

namespace App\Http\Controllers\v1;

use Exception;
use App\Enums\AccountType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\v1\Auth\LoginRequest;
use App\Repositories\v1\AuthRepository;
use App\Repositories\v1\LinkRepository;
use App\Repositories\v1\TokenRepository;
use App\Repositories\v1\AccountRepository;
use App\Http\Requests\v1\Auth\RegisterRequest;
use App\Http\Requests\v1\Auth\ResetPasswordRequest;
use App\Http\Requests\v1\Auth\ForgotPasswordRequest;

class AuthController extends Controller
{
    private const REFRESH_TOKEN_EXPIRY = 60 * 24 * 30; // 30 days

    public function __construct(
        private readonly AuthRepository $authRepository,
        private readonly AccountRepository $accountRepository,
        private readonly TokenRepository $tokenRepository,
        private readonly LinkRepository $linkRepository
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

            return parent::handleException($e);
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();


            if ($validatedData['accountTypeId'] === 1) {

                $accountData = [
                    'accountTypeId' =>  $validatedData['accountTypeId'],
                    'name' => $validatedData['name']
                ];

                $createdAccount = $this->accountRepository->create($accountData);

                $validatedData['accountId'] = $createdAccount['id'];
            }


            $data = $this->authRepository->register($validatedData);

            return $this->responseSuccess($data, 'User registered successfully.');
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    public function registerWithLink(RegisterRequest $request): JsonResponse
    {
        try {

            $data = $this->linkRepository->generateRegisterLink($request->all());

            return $this->responseSuccess($data, 'Generate Link successfully.');
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    public function logout(): JsonResponse
    {
        try {

            Auth::check() ? $this->tokenRepository->revokeAllTokens() : false;

            return $this->responseSuccess('', 'User logged out successfully !')->cookie('refresh_token', '', -1);
        } catch (Exception $e) {

            return parent::handleException($e);
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

            return parent::handleException($e);
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $data = $this->authRepository->forgotPassword($request->only('email'));

            return $this->responseSuccess($data, 'Email sent');
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $data = $this->authRepository->resetPassword($request->all());

            return $this->responseSuccess($data, 'Password Reset Successfully');
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }
}
