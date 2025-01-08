<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Permission;
use App\Http\Repositories\PermissionRepository;
use App\Http\Requests\Permission\PermissionGetRequest;
use App\Http\Requests\Permission\PermissionIndexRequest;
use App\Http\Requests\Permission\PermissionCreateRequest;
use App\Http\Requests\Permission\PermissionDeleteRequest;
use App\Http\Requests\Permission\PermissionUpdateRequest;

class PermissionController extends Controller
{
    public function __construct(private readonly PermissionRepository $permissionRepository) {}

    public function index(PermissionIndexRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $data = $this->permissionRepository->getAll($validatedData);

            return $this->responseSuccess($data, "Permissions fetched successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    public function show(PermissionGetRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $find = $this->permissionRepository->getByID($validatedData['id']);

            return $this->responseSuccess($find, "Permission find successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }


    public function store(PermissionCreateRequest $request)
    {
        try {

            $validatedData = $request->validated();

            $create = $this->permissionRepository->create($validatedData);

            return $this->responseSuccess($create, "Permission created successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    public function update(PermissionUpdateRequest $request)
    {
        try {

            $validatedData = $request->validated();

            $update = $this->permissionRepository->update($validatedData);

            return $this->responseSuccess($update, "Permission updated successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    public function destroy(PermissionDeleteRequest $request)
    {
        try {

            $validatedData = $request->validated();

            $delete = $this->permissionRepository->softDelete($validatedData['id']);

            return $this->responseSuccess($delete, "Permission deleted successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }
}
