<?php

namespace App\Http\Controllers\v1\Recruitment\Opportunity;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\v1\Controller;
use App\Repositories\v1\Recruitment\Opportunity\ResponsibilityRepository;
use App\Http\Requests\v1\Recruitment\Opportunity\Responsibility\IndexResponsibilityRequest;
use App\Http\Requests\v1\Recruitment\Opportunity\Responsibility\CreateResponsibilityRequest;
use App\Http\Requests\v1\Recruitment\Opportunity\Responsibility\UpdateResponsibilityRequest;

class ResponsibilityController extends Controller
{
    public function __construct(private readonly ResponsibilityRepository $responsibilityRepository) {}

    public function index(IndexResponsibilityRequest $request)
    {
        $this->checkPermission('view-all-opportunity-responsibility');

        $validatedData = $request->validated();

        $data = $this->responsibilityRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Opportunity Responsibility fetched successfully");
    }

    public function store(CreateResponsibilityRequest $request)
    {
        $this->checkPermission('create-opportunity-responsibility');

        $validatedData = $request->validated();

        $create = $this->responsibilityRepository->create($validatedData);

        return $this->responseSuccess($create, "Opportunity Responsibility created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $this->checkPermission('view-opportunity-responsibility');

        $find = $this->responsibilityRepository->getByID($id);

        return $this->responseSuccess($find, "Opportunity Responsibility find successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateResponsibilityRequest $request)
    {
        $this->checkPermission('update-opportunity-responsibility');

        $validatedData = $request->validated();

        $update = $this->responsibilityRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "Opportunity Responsibility updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->checkPermission('delete-opportunity-responsibility');

        $delete = $this->responsibilityRepository->softDelete($id);

        return $this->responseSuccess($delete, "Opportunity Responsibility deleted successfully");
    }
}
