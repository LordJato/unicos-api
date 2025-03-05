<?php

namespace App\Http\Controllers\v1\HR;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\v1\Controller;
use App\Repositories\v1\HR\EmployeeRepository;
use App\Http\Requests\v1\HR\Employee\EmployeeGetRequest;
use App\Http\Requests\v1\HR\Employee\EmployeeIndexRequest;
use App\Http\Requests\v1\HR\Employee\EmployeeCreateRequest;
use App\Http\Requests\v1\HR\Employee\EmployeeUpdateRequest;

class EmployeeController extends Controller
{
    public function __construct(private readonly EmployeeRepository $employeeRepository) {}


    public function index(EmployeeIndexRequest $request)
    {
        $validatedData = $request->validated();

        $data = $this->employeeRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Employees fetched successfully");
    }

    public function store(EmployeeCreateRequest $request)
    {
        $validatedData = $request->validated();

        $create = $this->employeeRepository->create($validatedData);

        return $this->responseSuccess($create, "Employee created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeGetRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $find = $this->employeeRepository->getByID($validatedData['id']);

        return $this->responseSuccess($find, "Employee find successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, EmployeeUpdateRequest $request)
    {
        $validatedData = $request->validated();

        $update = $this->employeeRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "Employee updated successfully");
    }
}
