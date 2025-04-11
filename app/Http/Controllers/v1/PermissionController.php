<?php

namespace App\Http\Controllers\v1;

use App\Repositories\v1\PermissionRepository;
use App\Http\Requests\v1\Permission\GetPermissionRequest;
use App\Http\Requests\v1\Permission\IndexPermissionRequest;
use App\Http\Requests\v1\Permission\CreatePermissionRequest;
use App\Http\Requests\v1\Permission\DeletePermissionRequest;
use App\Http\Requests\v1\Permission\UpdatePermissionRequest;

class PermissionController extends Controller
{
    public function __construct(private readonly PermissionRepository $permissionRepository) {}

    public function index(IndexPermissionRequest $request)
    {
        $this->checkPermission('view-all-permission');

        $validatedData = $request->validated();

        $data = $this->permissionRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Permissions fetched successfully");
    }

    public function show(GetPermissionRequest $request, $id)
    {
        $this->checkPermission('create-permission');

        $request->validated();

        $find = $this->permissionRepository->getByID($id);

        return $this->responseSuccess($find, "Permission find successfully");
    }


    public function store(CreatePermissionRequest $request)
    {
        $this->checkPermission('view-permission');

        $validatedData = $request->validated();

        $create = $this->permissionRepository->create($validatedData);

        return $this->responseSuccess($create, "Permission created successfully");
    }

    public function update(UpdatePermissionRequest $request, $id)
    {
        $this->checkPermission('update-permission');

        $validatedData = $request->validated();

        $update = $this->permissionRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "Permission updated successfully");
    }

    public function destroy(DeletePermissionRequest $request, $id)
    {
        $this->checkPermission('delete-permission');

        $request->validated();

        $delete = $this->permissionRepository->softDelete($id);

        return $this->responseSuccess($delete, "Permission deleted successfully");
    }
}
