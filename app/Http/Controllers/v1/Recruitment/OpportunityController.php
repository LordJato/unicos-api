<?php

namespace App\Http\Controllers\v1\Recruitment;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\v1\Controller;
use App\Http\Requests\v1\Recruitment\Opportunity\OpportunityCreateRequest;
use App\Http\Requests\v1\Recruitment\Opportunity\OpportunityIndexRequest;
use App\Http\Requests\v1\Recruitment\Opportunity\OpportunityUpdateRequest;
use App\Http\Requests\v1\Setup\OpportunityType\OpportunityTypeUpdateRequest;
use App\Repositories\v1\Recruitment\OpportunityRepository;

class OpportunityController extends Controller
{
    public function __construct(private readonly OpportunityRepository $opportunityRepository) {}

    public function index(OpportunityIndexRequest $request)
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
