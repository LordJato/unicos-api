<?php

namespace App\Http\Controllers\Recruitment;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Recruitment\Opportunity;
use App\Http\Requests\HR\Employee\EmployeeUpdateRequest;
use App\Http\Repositories\Recruitment\OpportunityRepository;

class OpportunityController extends Controller
{
    public function __construct(private readonly OpportunityRepository $opportunityRepository) {}

    public function index(Request $request)
    {
        try {

            $validatedData = $request->validated();

            $data = $this->opportunityRepository->getAll($validatedData);

            return $this->responseSuccess($data, "Opporyunity fetched successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validated();

            $create = $this->opportunityRepository->create($validatedData);

            return $this->responseSuccess($create, "Opportunity created successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $find = $this->opportunityRepository->getByID($validatedData['id']);

            return $this->responseSuccess($find, "Opportunity find successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $validatedData = $request->validated();

            $update = $this->opportunityRepository->update($validatedData);

            return $this->responseSuccess($update, "Opportunity updated successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }
}
