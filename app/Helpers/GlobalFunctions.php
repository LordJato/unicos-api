<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('searchString')) {
    function searchString(string $search): string
    {
        return urldecode($search) . '%';
    }
}

/**
 * Retrieves the currently authenticated user via the 'api' guard.
 *
 * @return \App\Models\User|null
 */

if (!function_exists('currentUser')) {
    function getCurrentUser(): ?\App\Models\User {
        $user = Auth::guard('api')->user();
        return $user instanceof \App\Models\User ? $user : null;
    }
}