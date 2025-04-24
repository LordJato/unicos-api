<?php

namespace App\Http\Controllers\v1\HR;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\v1\Controller;
use App\Repositories\v1\HR\Employee\EmployeePersonalRepository;

class EmployeePersonalController extends Controller
{
    public function __construct(private readonly EmployeePersonalRepository $employeePersonalRepository) {}

    public function index(Request $request)
    {
        $validatedData = $request->validated();

        $data = $this->employeePersonalRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Employee Personal fetched successfully");
    }


    public function store(Request $request)
    {
        $validatedData = $request->validated();

        $create = $this->employeePersonalRepository->create($validatedData);

        return $this->responseSuccess($create, "Employee Personal created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id): JsonResponse
    {
        $this->checkPermission('view-designation');

        $request->validated();

        $find = $this->employeePersonalRepository->getByID($id);

        return $this->responseSuccess($find, "Employee Personal find successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $validatedData = $request->validated();

        $update = $this->employeePersonalRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "Employee Personal updated successfully");
    }
}
