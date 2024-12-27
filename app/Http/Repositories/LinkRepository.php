<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\URL;

class LinkRepository
{

    public static function generateRegisterLink(array $params): string
    {

        $spaUrl = config('app.spa_url', env('SPA_URL', 'http://localhost:3000'));
        $expiration =  now()->addHours((int)$params['expiration']);
        unset($params['expiration']);


        URL::forceRootUrl($spaUrl);

        return URL::temporarySignedRoute(
            'secured.route', // Named route
            $expiration, // Expiration time
            $params
        );
    }
}
