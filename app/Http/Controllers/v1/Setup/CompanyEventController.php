<?php

namespace App\Http\Controllers\v1\Setup;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\v1\Controller;
use App\Repositories\v1\Setup\CompanyEventRepository;

class CompanyEventController extends Controller
{

    public function __construct(
        private readonly CompanyEventRepository $companyEventRepository
    ) {}

    public function index(Request $request): JsonResponse
    {
        $this->checkPermission('view-all-company-event');

        $validatedData = $request->validated();

        $data = $this->companyEventRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Company events fetched successfully");
    }

    public function store(Request $request)
    {
        $this->checkPermission('create-company-event');

        $validatedData = $request->validated();

        $create = $this->companyEventRepository->create($validatedData);

        return $this->responseSuccess($create, "Company event created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id): JsonResponse
    {
        $this->checkPermission('view-company-event');

        $request->validated();

        $find = $this->companyEventRepository->getByID($id);

        return $this->responseSuccess($find, "Company event find successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->checkPermission('update-company');

        $validatedData = $request->validated();

        $update = $this->companyEventRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "Company event updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $this->checkPermission('delete-company-event');

        $request->validated();

        $delete = $this->companyEventRepository->softDelete($id);

        return $this->responseSuccess($delete, "Company event deleted successfully");
    }
}
