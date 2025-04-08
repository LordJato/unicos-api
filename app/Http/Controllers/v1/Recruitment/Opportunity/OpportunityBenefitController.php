<?php

namespace App\Http\Controllers\v1\Recruitment;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\v1\Controller;
use App\Http\Requests\v1\Recruitment\Opportunity\Benefit\CreateBenefitRequest;
use App\Http\Requests\v1\Recruitment\Opportunity\Benefit\IndexBenefitRequest;
use App\Http\Requests\v1\Recruitment\Opportunity\Benefit\UpdateBenefitRequest;
use App\Repositories\v1\Recruitment\Opportunity\BenefitRepository;

class OpportunityBenefitController extends Controller
{
    public function __construct(private readonly BenefitRepository $benefitRepository) {}

    public function index(IndexBenefitRequest $request)
    {
        $this->checkPermission('view-all-opportunity-benefit');

        $validatedData = $request->validated();

        $data = $this->benefitRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Opporyunity Benefits fetched successfully");
    }

    public function store(CreateBenefitRequest $request)
    {
        $this->checkPermission('create-opportunity-benefit');

        $validatedData = $request->validated();

        $create = $this->benefitRepository->create($validatedData);

        return $this->responseSuccess($create, "Opportunity Benefit created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $this->checkPermission('view-opportunity-benefit');

        $find = $this->benefitRepository->getByID($id);

        return $this->responseSuccess($find, "Opportunity Benefit find successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UpdateBenefitRequest $request)
    {
        $this->checkPermission('update-opportunity-benefit');

        $validatedData = $request->validated();

        $update = $this->benefitRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "Opportunity Benefit updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->checkPermission('delete-opportunity-benefit');

        $delete = $this->benefitRepository->softDelete($id);

        return $this->responseSuccess($delete, "Opportunity Benefit deleted successfully");
    }
}
