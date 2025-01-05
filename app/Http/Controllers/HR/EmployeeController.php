<?php

namespace App\Http\Controllers\HR;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\HR\EmployeeRepository;
use App\Http\Requests\HR\Employee\EmployeeGetRequest;
use App\Http\Requests\HR\Employee\EmployeeIndexRequest;
use App\Http\Requests\HR\Employee\EmployeeCreateRequest;
use App\Http\Requests\HR\Employee\EmployeeUpdateRequest;

class EmployeeController extends Controller
{
    public function __construct(private readonly EmployeeRepository $employeeRepository) {}


    public function index(EmployeeIndexRequest $request)
    {
        try {

            $validatedData = $request->validated();

            $data = $this->employeeRepository->getAll($validatedData);

            return $this->responseSuccess($data, "Employees fetched successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    public function store(EmployeeCreateRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $create = $this->employeeRepository->create($validatedData);

            return $this->responseSuccess($create, "Employee created successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeGetRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $find = $this->employeeRepository->getByID($validatedData['id']);

            return $this->responseSuccess($find, "Employee find successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeUpdateRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $update = $this->employeeRepository->update($validatedData['id'], $validatedData);

            return $this->responseSuccess($update, "Employee updated successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }
}
