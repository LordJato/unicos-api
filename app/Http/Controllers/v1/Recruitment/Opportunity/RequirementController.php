<?php

namespace App\Http\Controllers\v1\Recruitment\Opportunity;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\v1\Controller;
use App\Repositories\v1\Recruitment\Opportunity\RequirementRepository;
use App\Http\Requests\v1\Recruitment\Opportunity\Requirement\CreateRequirementRequest;
use App\Http\Requests\v1\Recruitment\Opportunity\Requirement\IndexRequirementRequest;
use App\Http\Requests\v1\Recruitment\Opportunity\Requirement\UpdateRequirementRequest;

class RequirementController extends Controller
{
    public function __construct(private readonly RequirementRepository $requirementRepository) {}

    public function index(IndexRequirementRequest $request)
    {
        $this->checkPermission('view-all-opportunity-requirement');

        $validatedData = $request->validated();

        $data = $this->requirementRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Opporyunity Requirement fetched successfully");
    }

    public function store(CreateRequirementRequest $request)
    {
        $this->checkPermission('create-opportunity-requirement');

        $validatedData = $request->validated();

        $create = $this->requirementRepository->create($validatedData);

        return $this->responseSuccess($create, "Opportunity Requirement created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $this->checkPermission('view-opportunity-requirement');

        $find = $this->requirementRepository->getByID($id);

        return $this->responseSuccess($find, "Opportunity Requirement find successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateRequirementRequest $request)
    {
        $this->checkPermission('update-opportunity-requirement');

        $validatedData = $request->validated();

        $update = $this->requirementRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "Opportunity Requirement updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->checkPermission('delete-opportunity-requirement');

        $delete = $this->requirementRepository->softDelete($id);

        return $this->responseSuccess($delete, "Opportunity Requirement deleted successfully");
    }
}
