<?php

namespace App\Http\Controllers\v1\Recruitment;

use App\Repositories\v1\Recruitment\OpportunityBenefitRepository;
use Illuminate\Http\Request;

class OpportunityBenefitController
{
    public function __construct(private readonly OpportunityBenefitRepository $opportunityBenefit) {}

    public function index(Request $request)
    {
        $this->checkPermission('view-all-opportunity');

        $validatedData = $request->validated();

        $data = $this->opportunityRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Opporyunity fetched successfully");
    }

    public function store(OpportunityCreateRequest $request)
    {
        $this->checkPermission('create-opportunity');

        $validatedData = $request->validated();

        $create = $this->opportunityRepository->create($validatedData);

        return $this->responseSuccess($create, "Opportunity created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $this->checkPermission('view-opportunity');

        $find = $this->opportunityRepository->getByID($id);

        return $this->responseSuccess($find, "Opportunity find successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, OpportunityUpdateRequest $request)
    {
        $this->checkPermission('update-opportunity');

        $validatedData = $request->validated();

        $update = $this->opportunityRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "Opportunity updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->checkPermission('delete-opportunity');

        $delete = $this->opportunityRepository->softDelete($id);

        return $this->responseSuccess($delete, "Opportunity deleted successfully");
    }
}
