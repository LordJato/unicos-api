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
        try {
            Gate::authorize('view-all-permissions');
            
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
            Gate::authorize('create-permissions');

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
            Gate::authorize('view-permissions');

            $validatedData = $request->validated();

            $create = $this->permissionRepository->create($validatedData);

            return $this->responseSuccess($create, "Permission created successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    public function update($id, PermissionUpdateRequest $request)
    {
        try {
            Gate::authorize('update-permissions');

            $validatedData = $request->validated();

            $update = $this->permissionRepository->update($id, $validatedData);

            return $this->responseSuccess($update, "Permission updated successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    public function destroy(PermissionDeleteRequest $request)
    {
        try {
            Gate::authorize('destroy-permissions');
            
            $validatedData = $request->validated();

            $delete = $this->permissionRepository->softDelete($validatedData['id']);

            return $this->responseSuccess($delete, "Permission deleted successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }
}
