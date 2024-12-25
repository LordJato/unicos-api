<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LinkRepository
{

    public function generateRegisterLink(array $params): string
    {

        $parameters = $params;

        // if(!getCurrentUser()->hasRolesTo(['super-admin'])){

        //     $parameters = array_merge($params, ['account_id' => Hash::make(Auth::user()->account_id)]);
        // }

        return URL::temporarySignedRoute(
            'link.register', // Named route
            now()->addHours(12), // Expiration time
            $parameters
        );
    }
}
