<?php

namespace App\Http\Repositories;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Http\Response;
use Laravel\Passport\RefreshToken;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\TokenRepository;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Laravel\Passport\RefreshTokenRepository;

class AuthRepository
{

    public function login(array $data)
    {
        $user = $this->getUserByEmail($data['email']);

        if (!$user) {
            throw new Exception("User does not exist.", Response::HTTP_NOT_FOUND);
        }

        if (!$this->isValidPassword($user, $data)) {
            throw new Exception("Sorry, password does not match.", Response::HTTP_UNAUTHORIZED);
        }

        return $this->generateAuthToken($data);
    }

    public function register(array $data): UserResource
    {
        $user = User::create($this->prepareDataForRegister($data));

        if (!$user) {
            throw new Exception("Sorry, user does not registered, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new UserResource($user);
    }

    public function logout(): bool
    {
        if (Auth::check()) {

           return $this->revokeAllTokens();

        }

        return false;
    }

    public function forgotPassword(array $data): string
    {
        $status = Password::sendResetLink(
            $data
        );

        switch ($status) {
            case Password::RESET_LINK_SENT:
                return $status;
            case Password::INVALID_USER:
                throw new Exception("Invalid email address", Response::HTTP_BAD_REQUEST);
            default:
                throw new Exception("Failed to send mail", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function resetPassword(array $data): string
    {
        $status = Password::reset(
            $data,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return $status;
        }

        throw new Exception($status, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function isValidPassword(User $user, array $data): bool
    {
        return Hash::check($data['password'], $user->password);
    }

    public function generateAuthToken(array $data): array
    {
        $passwordGrantClient = Client::where('password_client', 1)->first();

        $data = [
            'grant_type' => 'password',
            'client_id' => $passwordGrantClient->id,
            'client_secret' => $passwordGrantClient->secret,
            'username' => $data['email'],
            'password' => $data['password'],
            'scope' => '',
        ];

        $tokenRequest = Request::create('/oauth/token', 'post', $data);

        $tokenResponse = app()->handle($tokenRequest);

        return json_decode($tokenResponse->getContent(), true);
    }

    public function prepareDataForRegister(array $data): array
    {
        return [
            'account_id' => $data['account_id'] ?? Auth::user()->accountId,
            'email'    => $data['email'],
            'phone'    => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
        ];
    }

    //Use this when revoke one token
    public function revokeToken($tokenId): bool
    {
        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);
        $tokenRepository->revokeAccessToken($tokenId);
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);

        return true;
    }

    public function revokeAllTokens(): bool
    {
        $user = Auth::user();
        $refreshTokenRepository = app(RefreshTokenRepository::class);
        $user->tokens->each(function ($token) use ($refreshTokenRepository) {
            //revoke access token
            $token->revoke();
            //revoce refresh token
            $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);
        });

        return true;
    }

    public function deleteAllTokens(): bool
    {
        $user = Auth::user();

        $user->tokens->each(function ($token) {
            $token->delete();
            RefreshToken::where('access_token_id', $token->id)->delete();
        });

        return true;
    }
}
