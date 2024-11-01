<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Permission;
use App\Traits\ResponseTrait;
use App\Http\Repositories\PermissionRepository;
use App\Http\Requests\Permission\PermissionGetRequest;
use App\Http\Requests\Permission\PermissionIndexRequest;
use App\Http\Requests\Permission\PermissionCreateRequest;
use App\Http\Requests\Permission\PermissionDeleteRequest;
use App\Http\Requests\Permission\PermissionUpdateRequest;

class PermissionController extends Controller
{
    use ResponseTrait;

    private $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function index(PermissionIndexRequest $request)
    {
        try {
            $data = $this->permissionRepository->getAll($request);

            return $this->responseSuccess($data, "Permissions fetched successfully");
        } catch (Exception $e) {
            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    public function show(PermissionGetRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $find = $this->permissionRepository->getByID($validatedData['id']);

            return $this->responseSuccess($find, "Permission find successfully");
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }


    public function store(PermissionCreateRequest $request)
    {
        try {

            $validatedData = $request->validated();

            $create = $this->permissionRepository->create($validatedData);

            return $this->responseSuccess($create, "Permission created successfully");
        } catch (Exception $e) {
            return $e;
            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    public function update(PermissionUpdateRequest $request)
    {
        try {

            $validatedData = $request->validated();

            $update = $this->permissionRepository->update($validatedData);

            return $this->responseSuccess($update, "Permission updated successfully");
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    public function destroy(PermissionDeleteRequest $request)
    {
        try {

            $validatedData = $request->validated();

            $role = Permission::where('id', $validatedData['id'])->delete();

            return $this->responseSuccess($role, "Permission deleted successfully");
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }
}
