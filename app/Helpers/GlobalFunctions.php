<?php

if (!function_exists('searchString')) {
    function searchString(string $search): string
    {
        return urldecode($search) . '%';
    }
}