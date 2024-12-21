<?php

namespace App\Http\Controllers\Setting;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Setting\DepartmentRepository;
use App\Http\Requests\Setting\Setting\Department\DepartmentCreateRequest;

class DepartmentController extends Controller
{
    use ResponseTrait;

    public $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $data = $this->departmentRepository->getAll($request);

            return $this->responseSuccess($data, "Department fetched successfully");
        } catch (Exception $e) {
            return $this->responseError([], $e->getMessage(), $this->getStatusCode($e->getCode()));
        }
    }

    public function store(DepartmentCreateRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $create = $this->departmentRepository->create($validatedData);

            return $this->responseSuccess($create, "Department created successfully");
        } catch (Exception $e) {
            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request): JsonResponse
    {
        try {

            $find = $this->departmentRepository->getByID($request->query('id'));

            return $this->responseSuccess($find, "Department find successfully");
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {

            // $update = $this->companyRepository->update($request->query('id'), $companyRequest->all());

            // return $this->responseSuccess($update, "Company updated successfully");
        } catch (Exception $e) {
            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }
}
