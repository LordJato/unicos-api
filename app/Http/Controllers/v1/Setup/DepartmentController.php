<?php

namespace App\Http\Controllers\Setup;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\CompanyRepository;
use App\Http\Repositories\Setup\DepartmentRepository;
use App\Http\Requests\Setup\Department\DepartmentCreateRequest;
use App\Http\Requests\Setup\Department\DepartmentIndexRequest;
use App\Http\Requests\Setup\Department\DepartmentUpdateRequest;

class DepartmentController extends Controller
{

    public function __construct(
        private readonly DepartmentRepository $departmentRepository,
        private readonly CompanyRepository $companyRepository
    ) {}

    public function index(DepartmentIndexRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
         
            $data = $this->departmentRepository->getAll($validatedData);

            return $this->responseSuccess($data, "Department fetched successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    public function store(DepartmentCreateRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $create = $this->departmentRepository->create($validatedData);

            return $this->responseSuccess($create, "Department created successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        try {

            $find = $this->departmentRepository->getByID($id);

            return $this->responseSuccess($find, "Department find successfully");
        } catch (Exception $e) {

            return parent::handleException($e); 
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, DepartmentUpdateRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $update = $this->departmentRepository->update($id, $validatedData);

            return $this->responseSuccess($update, "Department updated successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $delete = $this->departmentRepository->softDelete($id);

            return $this->responseSuccess($delete, "Department deleted successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }
}
