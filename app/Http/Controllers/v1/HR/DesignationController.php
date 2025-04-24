<?php

namespace App\Http\Controllers\v1\HR;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\v1\Controller;
use App\Repositories\v1\HR\DesignationRepository;

class DesignationController extends Controller
{
    public function __construct(private readonly DesignationRepository $designationRepository) {}

    public function index(Request $request)
    {
        $validatedData = $request->validated();

        $data = $this->designationRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Designation fetched successfully");
    }

    public function store(Request $request)
    {
        $validatedData = $request->validated();

        $create = $this->designationRepository->create($validatedData);

        return $this->responseSuccess($create, "Designation created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id): JsonResponse
    {
        $this->checkPermission('view-department');

        $request->validated();

        $find = $this->designationRepository->getByID($id);

        return $this->responseSuccess($find, "Designation find successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $validatedData = $request->validated();

        $update = $this->designationRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "Designation updated successfully");
    }
}
