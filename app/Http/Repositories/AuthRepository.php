<?php

namespace App\Http\Repositories;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
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
    /**
     * Login user.
     *
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function login(array $data): bool
    {
        $user = $this->getUserByEmail($data['email']);

        if (!$user) {
            throw new Exception("User does not exist.", Response::HTTP_NOT_FOUND);
        }

        if (!$this->isValidPassword($user, $data)) {
            throw new Exception("Sorry, password does not match.", Response::HTTP_UNAUTHORIZED);
        }

        return true;
    }


    /**
     * Register user.
     *
     * @param array $data
     * @return UserResource
     * @throws Exception
     */
    public function register(array $data): UserResource
    {
        $user = User::create($this->prepareDataForRegister($data));

        if (!$user) {
            throw new Exception("Sorry, user does not registered, Please try again.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new UserResource($user);
    }

    /**
     * Logout user.
     *
     * @return bool
     */
    public function logout(): bool
    {
        return Auth::check() ? $this->revokeAllTokens() : false;
    }

    /**
     * Forgot password.
     *
     * @param array $data
     * @return string
     * @throws Exception
     */

    public function forgotPassword(array $data): string
    {
        $status = Password::sendResetLink($data);

        switch ($status) {
            case Password::RESET_LINK_SENT:
                return $status;
            case Password::INVALID_USER:
                throw new Exception("Invalid email address", Response::HTTP_BAD_REQUEST);
            default:
                throw new Exception("Failed to send mail", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Reset password.
     *
     * @param array $data
     * @return string
     * @throws Exception
     */
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

    /**
     * Get user by email.
     *
     * @param string $email
     * @return User|null
     */
    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Validate password.
     *
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function isValidPassword(User $user, array $data): bool
    {
        return Hash::check($data['password'], $user->password);
    }

    /**
     * Revoke token.
     *
     * @param $tokenId
     * @return bool
     */
    public function revokeToken($tokenId): bool
    {
        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);

        $tokenRepository->revokeAccessToken($tokenId);
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);

        return true;
    }

    /**
     * Revoke all tokens.
     *
     * @return bool
     */
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


    /**
     * Delete all tokens.
     *
     * @return bool
     */
    public function deleteAllTokens(): bool
    {
        $user = Auth::user();

        $user->tokens->each(function ($token) {
            $token->delete();
            RefreshToken::where('access_token_id', $token->id)->delete();
        });

        return true;
    }

    /**
     * Prepare registration data.
     *
     * @param array $data
     * @return array
     */
    private function prepareDataForRegister(array $data): array
    {
        return [
            'account_id' => $data['account_id'] ?? Auth::user()->accountId,
            'email'    => $data['email'],
            'phone'    => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
        ];
    }
}
