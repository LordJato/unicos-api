<?php

use Illuminate\Support\Facades\Auth;


/**
 * Retrieves the currently authenticated user via the 'api' guard.
 *
 * @return \App\Models\User|null
 */

if (!function_exists('getCurrentUser')) {
    function getCurrentUser(): ?\App\Models\User {
        $user = Auth::guard('api')->user();
        return $user instanceof \App\Models\User ? $user : null;
    }
}