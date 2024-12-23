<?php

namespace App\Http\Repositories;

use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Exception;
use Illuminate\Http\Response;

class TokenRepository
{
    private const TOKEN_ENDPOINT = '/oauth/token';

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
    public function refreshAccessToken(string $refreshToken): array
    {
        if (empty($refreshToken)) {
            throw new Exception('Refresh token is not found.', Response::HTTP_NOT_FOUND);
        }

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
}

