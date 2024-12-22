<?php

namespace App\Http\Repositories;

use Exception;
use Illuminate\Http\Request;
use Laravel\Passport\Client;



class TokenRepository
{

    public function generateAcessToken(array $params): array
    {
        $data = [
            'grant_type' => 'password',
            'username' => $params['email'],
            'password' => $params['password'],
            'scope' => '',
        ];

        return $this->getToken($data);
    }

    public function generateAccessTokenFromRefreshToken(string $refreshToken): array
    {

        if (empty($refreshToken)) {
            throw new Exception('Refresh token is not found.', 401);
        }

        $data = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'scope' => '',
        ];

        return $this->getToken($data);
    }

    private function getToken(array $data): array
    {

        $passwordGrantClient = Client::where('password_client', 1)->first();

        $data['client_id'] = $passwordGrantClient->id;
        $data['client_secret'] = $passwordGrantClient->secret;

        $tokenRequest = Request::create('/oauth/token', 'post', $data);

        $tokenResponse = app()->handle($tokenRequest);

        return json_decode($tokenResponse->getContent(), true);
    }
}
