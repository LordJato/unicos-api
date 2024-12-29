<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\URL;

class LinkRepository
{

    public static function generateRegisterLink(array $params): string
    {
        $defaults = [
            'expiration' => 1,
            // Add other required keys here
        ];

        $params = array_merge($defaults, $params);

        $params['expiration'] = (int)$params['expiration'];
        $spaUrl = config('app.spa_url', env('SPA_URL', 'http://localhost:3000'));
        $expiration = now()->addHours($params['expiration']);
        unset($params['expiration']);

        URL::forceRootUrl($spaUrl);

        return URL::temporarySignedRoute(
            'secured.route', // Named route
            $expiration, // Expiration time
            $params
        );
    }
}
