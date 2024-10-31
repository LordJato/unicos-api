<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;

class RoleController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        try {
            return $this->responseSuccess(Role::all(), "Roles fetched successfully");
        } catch (Exception $e) {
            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    public function store(Request $request)
    {
        try {
            $toSlug = Str::slug($request->name, '-');

            $data = [
                'name' => $request->name,
                'slug' => $toSlug
            ];

            $create = Role::insert($data);

            return $this->responseSuccess($data, "Role created successfully");

        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    public function rolesPermissions()
    {
        try {
            return $this->responseSuccess(Role::with('permissions')->get(), "Roles fetched successfully");
        } catch (Exception $e) {
            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }
}
