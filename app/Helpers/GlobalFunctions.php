<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('searchString')) {
    function searchString(string $search): string
    {
        return urldecode($search) . '%';
    }
}

if (!function_exists('currentUser')) {
    function currentUser() {
        $user = Auth::guard('api')->user();
        return $user instanceof \App\Models\User ? $user : null;
    }
}