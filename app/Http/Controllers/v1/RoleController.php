<?php

namespace App\Http\Controllers\v1;

use Exception;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\v1\RoleRepository;
use App\Http\Requests\v1\Role\RoleGetRequest;
use App\Http\Requests\v1\Role\RoleIndexRequest;
use App\Http\Requests\v1\Role\RoleCreateRequest;
use App\Http\Requests\v1\Role\RoleDeleteRequest;
use App\Http\Requests\v1\Role\RoleUpdateRequest;

class RoleController extends Controller
{
    public function __construct(private readonly RoleRepository $roleRepository) {}

    public function index(RoleIndexRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $data = $this->roleRepository->getAll($validatedData);

            return $this->responseSuccess($data, "Roles fetched successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    public function show(RoleGetRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $find = $this->roleRepository->getById($validatedData['id']);

            return $this->responseSuccess($find, "Role find successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }


    public function store(RoleCreateRequest $request)
    {
        try {

            $validatedData = $request->validated();

            $create = $this->roleRepository->create($validatedData);

            return $this->responseSuccess($create, "Role created successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    public function update($id, RoleUpdateRequest $request)
    {
        try {

            $validatedData = $request->validated();

            $update = $this->roleRepository->update($id, $validatedData);

            return $this->responseSuccess($update, "Role updated successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    public function destroy(RoleDeleteRequest $request)
    {
        try {

            $validatedData = $request->validated();

            $delete = $this->roleRepository->softDelete($validatedData['id']);

            return $this->responseSuccess($delete, "Role deleted successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    public function attachPermissions(Request $request)
    {
        try {

            $role = $this->roleRepository->getByID($request->roleID);
          
            $attach = $role->setPermissionsWihtoutDetaching($request->permissions);

            return $this->responseSuccess($attach, "Permissions attached successfully.");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    public function rolesPermissions()
    {
        try {
            $rolesPermissions = Role::with('permissions')->get();
            return $this->responseSuccess($rolesPermissions, "Roles fetched successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }
}
