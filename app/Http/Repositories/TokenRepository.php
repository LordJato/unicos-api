<?php

namespace App\Http\Repositories;

use Exception;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Http\Response;
use Laravel\Passport\RefreshToken;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository as LaravelTokenRepository;

class TokenRepository
{
    private const TOKEN_ENDPOINT = '/oauth/token';

    public function __construct(
        private RefreshTokenRepository $refreshTokenRepository,
        private LaravelTokenRepository $laravelTokenRepository
    ) {}

    /**
     * Generates an access token.
     *
     * @param array $params
     * @return array
     */
    public function generateAccessToken(array $params): array
    {
        $data = $this->createTokenData($params, 'password');

        return $this->getToken($data);
    }

    /**
     * Refreshes an access token.
     *
     * @param string $refreshToken
     * @return array
     * @throws InvalidRefreshTokenException
     */
    public function refreshAccessToken(string $refreshToken = null): array
    {
        if (empty($refreshToken)) {
            throw new Exception('Refresh token is not found.', Response::HTTP_NOT_FOUND);
        }

        //check if refresh token still valid


        $data = $this->createTokenData(['refresh_token' => $refreshToken], 'refresh_token');

        return $this->getToken($data);
    }

    /**
     * Creates token request data.
     *
     * @param array $params
     * @param string $grantType
     * @return array
     */
    private function createTokenData(array $params, string $grantType): array
    {
        return [
            'grant_type' => $grantType,
            'username' => $params['email'] ?? null,
            'password' => $params['password'] ?? null,
            'refresh_token' => $params['refresh_token'] ?? null,
            'scope' => '',
        ];
    }

    /**
     * Retrieves a token.
     *
     * @param array $data
     * @return array
     */
    private function getToken(array $data): array
    {
        $passwordGrantClient = Client::where('password_client', 1)->first();

        if (!$passwordGrantClient) {
            throw new Exception('Password grant client not found.', Response::HTTP_NOT_FOUND);
        }

        $data['client_id'] = $passwordGrantClient->id;
        $data['client_secret'] = $passwordGrantClient->secret;

        $tokenRequest = Request::create(self::TOKEN_ENDPOINT, 'post', $data);

        $tokenResponse = app()->handle($tokenRequest);

        return json_decode($tokenResponse->getContent(), true);
    }

    /**
     * Revoke token.
     *
     * @param $tokenId
     * @return bool
     */
    public function revokeToken($tokenId): bool
    {
        $tokenRepository = $this->laravelTokenRepository;
        $refreshTokenRepository = $this->refreshTokenRepository;

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
        $refreshTokenRepository = $this->refreshTokenRepository;
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
}
