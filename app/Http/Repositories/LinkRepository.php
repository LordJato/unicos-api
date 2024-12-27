<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\URL;

class LinkRepository
{

    public static function generateRegisterLink(array $params): string
    {

        $spaUrl = config('app.spa_url', env('SPA_URL', 'http://localhost:3000'));
        URL::forceRootUrl($spaUrl);
        
        return URL::temporarySignedRoute(
            'secured.route', // Named route
            now()->addHours((int)$params['expiration']), // Expiration time
            $params
        );
    }
}
