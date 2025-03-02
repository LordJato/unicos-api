<?php

namespace App\Http\Controllers\v1;

use Exception;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use App\Repositories\v1\RoleRepository;
use App\Http\Requests\v1\Role\RoleGetRequest;
use App\Http\Requests\v1\Role\RoleIndexRequest;
use App\Http\Requests\v1\Role\RoleCreateRequest;
use App\Http\Requests\v1\Role\RoleDeleteRequest;
use App\Http\Requests\v1\Role\RoleUpdateRequest;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    public function __construct(private readonly RoleRepository $roleRepository) {}

    public function index(RoleIndexRequest $request): JsonResponse
    {
        $this->checkPermission('view-all-role');

        $validatedData = $request->validated();

        $data = $this->roleRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Roles fetched successfully");
    }

    public function show(RoleGetRequest $request, int $id): JsonResponse
    {
        $this->checkPermission('view-role');

        $request->validated();

        $role = $this->roleRepository->getById($id);

        return $this->responseSuccess($role, "Role found successfully");
    }

    public function store(RoleCreateRequest $request): JsonResponse
    {
        $this->checkPermission('create-role');

        $validatedData = $request->validated();

        $role = $this->roleRepository->create($validatedData);

        return $this->responseSuccess($role, "Role created successfully");
    }

    public function update(RoleUpdateRequest $request, int $id): JsonResponse
    {
        $this->checkPermission('update-role');

        $validatedData = $request->validated();

        $role = $this->roleRepository->update($id, $validatedData);

        return $this->responseSuccess($role, "Role updated successfully");
    }

    public function destroy(RoleDeleteRequest $request, int $id): JsonResponse
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
