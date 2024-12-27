<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Laravel\Passport\RefreshToken;
use Symfony\Component\HttpFoundation\Response;

class CheckRefreshToken
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

       
        // Retrieve the refresh token from the cookie
        $refreshToken = $request->cookie('refresh_token');
        if (!$refreshToken) {
            return $this->responseError([], 'Refresh token not found.', 404);
        }

        // Check if the token exists in the database
        $token = RefreshToken::where('id', $refreshToken)->first();
        if (!$token) {
            return $this->responseError([], 'Invalid refresh token.', 401);
        }

        // Check if the token is revoked
        if ($token->revoked) {
            return $this->responseError([], 'Refresh token has been revoked.', 401);
        }

        // Check if the token is expired
        if ($token->expires_at < now()) {
            return $this->responseError([], 'Refresh token has expired.', 401);
        }

        return $next($request);
    }
}
