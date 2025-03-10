<?php

namespace App\Http\Controllers\v1\Recruitment;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\v1\Controller;
use App\Repositories\v1\Recruitment\OpportunityRepository;

class OpportunityController extends Controller
{
    public function __construct(private readonly OpportunityRepository $opportunityRepository) {}

    public function index(Request $request)
    {
        $validatedData = $request->validated();

        $data = $this->opportunityRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Opporyunity fetched successfully");
    }

    public function store(Request $request)
    {
        $validatedData = $request->validated();

        $create = $this->opportunityRepository->create($validatedData);

        return $this->responseSuccess($create, "Opportunity created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request): JsonResponse
    {
        $validatedData = $request->validated();

        $find = $this->opportunityRepository->getByID($validatedData['id']);

        return $this->responseSuccess($find, "Opportunity find successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validated();

        $update = $this->opportunityRepository->update($validatedData);

        return $this->responseSuccess($update, "Opportunity updated successfully");
    }
}
