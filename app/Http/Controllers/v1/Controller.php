<?php

namespace App\Http\Controllers\v1;

use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

abstract class Controller
{
    use ResponseTrait;
    
    protected function checkPermission(string|array $permissions): void
{
    if (Gate::any((array) $permissions)) {
        return;
    }

    abort(Response::HTTP_FORBIDDEN, 'Forbidden');
}
}
