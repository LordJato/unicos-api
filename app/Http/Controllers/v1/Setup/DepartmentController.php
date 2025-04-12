<?php

namespace App\Http\Controllers\v1\Setup;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\v1\Controller;
use App\Repositories\v1\CompanyRepository;
use App\Repositories\v1\Setup\DepartmentRepository;
use App\Http\Requests\v1\Setup\Department\GetDepartmentRequest;
use App\Http\Requests\v1\Setup\Department\IndexDepartmentRequest;
use App\Http\Requests\v1\Setup\Department\CreateDepartmentRequest;
use App\Http\Requests\v1\Setup\Department\DeleteDepartmentRequest;
use App\Http\Requests\v1\Setup\Department\UpdateDepartmentRequest;

class DepartmentController extends Controller
{

    public function __construct(
        private readonly DepartmentRepository $departmentRepository,
        private readonly CompanyRepository $companyRepository
    ) {}

    public function index(IndexDepartmentRequest $request): JsonResponse
    {
        $this->checkPermission('view-all-department');

        $validatedData = $request->validated();

        $data = $this->departmentRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Department fetched successfully");
    }

    public function store(CreateDepartmentRequest $request)
    {
        $this->checkPermission('create-department');

        $validatedData = $request->validated();

        $create = $this->departmentRepository->create($validatedData);

        return $this->responseSuccess($create, "Department created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(GetDepartmentRequest $request, $id): JsonResponse
    {
        $this->checkPermission('view-department');

        $request->validated();

        $find = $this->departmentRepository->getByID($id);

        return $this->responseSuccess($find, "Department find successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, $id)
    {
        $this->checkPermission('update-department');

        $validatedData = $request->validated();

        $update = $this->departmentRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "Department updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteDepartmentRequest $request, $id)
    {
        $this->checkPermission('delete-department');

        $request->validated();

        $delete = $this->departmentRepository->softDelete($id);

        return $this->responseSuccess($delete, "Department deleted successfully");
    }
}
