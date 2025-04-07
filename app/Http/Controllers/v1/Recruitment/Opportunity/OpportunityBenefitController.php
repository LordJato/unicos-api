<?php

namespace App\Http\Controllers\v1\Recruitment;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\v1\Controller;
use App\Http\Requests\v1\Recruitment\OpportunityBenefit\OpportunityBenefitCreateRequest;
use App\Http\Requests\v1\Recruitment\OpportunityBenefit\OpportunityBenefitIndexRequest;
use App\Http\Requests\v1\Recruitment\OpportunityBenefit\OpportunityBenefitUpdateRequest;
use App\Repositories\v1\Recruitment\OpportunityBenefitRepository;

class OpportunityBenefitController extends Controller
{
    public function __construct(private readonly OpportunityBenefitRepository $opportunityBenefitRepository) {}

    public function index(OpportunityBenefitIndexRequest $request)
    {
        $this->checkPermission('view-all-opportunity-benefit');

        $validatedData = $request->validated();

        $data = $this->opportunityBenefitRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Opporyunity Benefits fetched successfully");
    }

    public function store(OpportunityBenefitCreateRequest $request)
    {
        $this->checkPermission('create-opportunity-benefit');

        $validatedData = $request->validated();

        $create = $this->opportunityBenefitRepository->create($validatedData);

        return $this->responseSuccess($create, "Opportunity Benefit created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $this->checkPermission('view-opportunity-benefit');

        $find = $this->opportunityBenefitRepository->getByID($id);

        return $this->responseSuccess($find, "Opportunity Benefit find successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, OpportunityBenefitUpdateRequest $request)
    {
        $this->checkPermission('update-opportunity-benefit');

        $validatedData = $request->validated();

        $update = $this->opportunityBenefitRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "Opportunity Benefit updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->checkPermission('delete-opportunity-benefit');

        $delete = $this->opportunityBenefitRepository->softDelete($id);

        return $this->responseSuccess($delete, "Opportunity Benefit deleted successfully");
    }
}
