<?php

namespace App\Http\Controllers\v1\HR;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\v1\Controller;
use App\Repositories\v1\HR\Employee\EmployeeEmergencyRepository;

class EmployeeEmergencyController extends Controller
{
    public function __construct(private readonly EmployeeEmergencyRepository $employeeEmergencyRepository) {}

    public function index(Request $request)
    {
        $validatedData = $request->validated();

        $data = $this->employeeEmergencyRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Employees fetched successfully");
    }

    public function store(Request $request)
    {
        $validatedData = $request->validated();

        $create = $this->employeeEmergencyRepository->create($validatedData);

        return $this->responseSuccess($create, "Employee Emergency created successfully");
    }

    
    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id): JsonResponse
    {
        $this->checkPermission('view-designation');

        $request->validated();

        $find = $this->employeeEmergencyRepository->getByID($id);

        return $this->responseSuccess($find, "Employee Emergency find successfully");
    }

     /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $validatedData = $request->validated();

        $update = $this->employeeEmergencyRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "Employee Emergency updated successfully");
    }

}
