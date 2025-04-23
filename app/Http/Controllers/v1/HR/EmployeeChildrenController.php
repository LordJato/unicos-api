<?php

namespace App\Http\Controllers\v1\HR;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\v1\Controller;
use App\Repositories\v1\HR\Employee\EmployeeChildrenRepository;

class EmployeeChildrenController extends Controller
{
    public function __construct(private readonly EmployeeChildrenRepository $employeeChildrenRepository) {}

    public function index(Request $request)
    {
        $validatedData = $request->validated();

        $data = $this->employeeChildrenRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Employee Children fetched successfully");
    }

    public function store(Request $request)
    {
        $validatedData = $request->validated();

        $create = $this->employeeChildrenRepository->create($validatedData);

        return $this->responseSuccess($create, "Employee Children created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id): JsonResponse
    {
        $this->checkPermission('view-designation');

        $request->validated();

        $find = $this->employeeChildrenRepository->getByID($id);

        return $this->responseSuccess($find, "Employee Children find successfully");
    }
}
