<?php

namespace App\Http\Controllers\v1\Setup;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\v1\Controller;
use App\Repositories\v1\CompanyRepository;
use App\Repositories\v1\Setup\DepartmentRepository;
use App\Http\Requests\v1\Setup\Department\DepartmentCreateRequest;
use App\Http\Requests\v1\Setup\Department\DepartmentDeleteRequest;
use App\Http\Requests\v1\Setup\Department\DepartmentGetRequest;
use App\Http\Requests\v1\Setup\Department\DepartmentIndexRequest;
use App\Http\Requests\v1\Setup\Department\DepartmentUpdateRequest;

class DepartmentController extends Controller
{

    public function __construct(
        private readonly DepartmentRepository $departmentRepository,
        private readonly CompanyRepository $companyRepository
    ) {}

    public function index(DepartmentIndexRequest $request): JsonResponse
    {
        $this->checkPermission('view-all-department');

        $validatedData = $request->validated();

        $data = $this->departmentRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Department fetched successfully");
    }

    public function store(DepartmentCreateRequest $request)
    {
        $this->checkPermission('create-department');

        $validatedData = $request->validated();

        $create = $this->departmentRepository->create($validatedData);

        return $this->responseSuccess($create, "Department created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(DepartmentGetRequest $request, $id): JsonResponse
    {
        $this->checkPermission('view-department');

        $request->validated();

        $find = $this->departmentRepository->getByID($id);

        return $this->responseSuccess($find, "Department find successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentUpdateRequest $request, $id)
    {
        $this->checkPermission('update-department');

        $validatedData = $request->validated();

        $update = $this->departmentRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "Department updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DepartmentDeleteRequest $request, $id)
    {
        $this->checkPermission('delete-department');

        $request->validated();

        $delete = $this->departmentRepository->softDelete($id);

        return $this->responseSuccess($delete, "Department deleted successfully");
    }
}
