<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Exception;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;

class PermissionController extends Controller
{
    use ResponseTrait;
    
    public function index(Request $request)
    {
        try {
            return $this->responseSuccess(Permission::all(), "Permission fetched successfully");
        } catch (Exception $e) {
            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }
}
