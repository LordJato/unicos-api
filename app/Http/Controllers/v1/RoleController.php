<?php

namespace App\Http\Controllers\v1;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\v1\RoleRepository;
use App\Http\Requests\v1\Role\GetRoleRequest;
use App\Http\Requests\v1\Role\IndexRoleRequest;
use App\Http\Requests\v1\Role\CreateRoleRequest;
use App\Http\Requests\v1\Role\DeleteRoleRequest;
use App\Http\Requests\v1\Role\UpdateRoleRequest;

class RoleController extends Controller
{
    public function __construct(private readonly RoleRepository $roleRepository) {}

    public function index(IndexRoleRequest $request): JsonResponse
    {
        $this->checkPermission('view-all-role');

        $validatedData = $request->validated();

        $data = $this->roleRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Roles fetched successfully");
    }

    public function show(GetRoleRequest $request, int $id): JsonResponse
    {
        $this->checkPermission('view-role');

        $request->validated();

        $role = $this->roleRepository->getById($id);

        return $this->responseSuccess($role, "Role found successfully");
    }

    public function store(CreateRoleRequest $request): JsonResponse
    {
        $this->checkPermission('create-role');

        $validatedData = $request->validated();

        $role = $this->roleRepository->create($validatedData);

        return $this->responseSuccess($role, "Role created successfully");
    }

    public function update(UpdateRoleRequest $request, int $id): JsonResponse
    {
        $this->checkPermission('update-role');

        $validatedData = $request->validated();

        $role = $this->roleRepository->update($id, $validatedData);

        return $this->responseSuccess($role, "Role updated successfully");
    }

    public function destroy(DeleteRoleRequest $request, int $id): JsonResponse
    {
        $this->checkPermission('delete-role');

        $request->validated();

        $role = $this->roleRepository->softDelete($id);

        return $this->responseSuccess($role, "Role deleted successfully");
    }

    public function attachPermissions(Request $request)
    {
        $role = $this->roleRepository->getByID($request->roleID);

        $attach = $role->setPermissionsWihtoutDetaching($request->permissions);

        return $this->responseSuccess($attach, "Permissions attached successfully.");
    }

    public function rolesPermissions()
    {
        $rolesPermissions = Role::with('permissions')->get();

        return $this->responseSuccess($rolesPermissions, "Roles fetched successfully");
    }
}
