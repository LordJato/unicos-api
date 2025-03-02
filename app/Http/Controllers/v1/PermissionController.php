<?php

namespace App\Http\Controllers\v1;

use Exception;
use Illuminate\Support\Facades\Gate;
use App\Repositories\v1\PermissionRepository;
use App\Http\Requests\v1\Permission\PermissionGetRequest;
use App\Http\Requests\v1\Permission\PermissionIndexRequest;
use App\Http\Requests\v1\Permission\PermissionCreateRequest;
use App\Http\Requests\v1\Permission\PermissionDeleteRequest;
use App\Http\Requests\v1\Permission\PermissionUpdateRequest;

class PermissionController extends Controller
{
    public function __construct(private readonly PermissionRepository $permissionRepository) {}

    public function index(PermissionIndexRequest $request)
    {
        $this->checkPermission('view-all-permission');

        $validatedData = $request->validated();

        $data = $this->permissionRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Permissions fetched successfully");
    }

    public function show(PermissionGetRequest $request, $id)
    {
        $this->checkPermission('create-permission');

        $request->validated();

        $find = $this->permissionRepository->getByID($id);

        return $this->responseSuccess($find, "Permission find successfully");
    }


    public function store(PermissionCreateRequest $request)
    {
        $this->checkPermission('view-permission');

        $validatedData = $request->validated();

        $create = $this->permissionRepository->create($validatedData);

        return $this->responseSuccess($create, "Permission created successfully");
    }

    public function update(PermissionUpdateRequest $request, $id)
    {
        $this->checkPermission('update-permission');

        $validatedData = $request->validated();

        $update = $this->permissionRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "Permission updated successfully");
    }

    public function destroy(PermissionDeleteRequest $request, $id)
    {
        $this->checkPermission('delete-permission');

        $request->validated();

        $delete = $this->permissionRepository->softDelete($id);

        return $this->responseSuccess($delete, "Permission deleted successfully");
    }
}
