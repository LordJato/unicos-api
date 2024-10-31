<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\RoleUpdateRequest;
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

            $role = $this->preparingDataForDB($request->all());

            Role::create($role);

            return $this->responseSuccess($role, "Role created successfully");
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    public function update(Request $request, RoleUpdateRequest $updateRequest)
    {
        try {

            $role = $this->preparingDataForDB($updateRequest->all());

            Role::where('id', $request->query('id'))->update($role);
 
            return $this->responseSuccess($role, "Account updated successfully");
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    private function preparingDataForDB(array $data) : array {

        $toSlug = Str::slug($data['name'], '-');

        return [
            'name' => $data['name'],
            'slug'    => $toSlug,
        ];
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
