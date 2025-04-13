<?php

namespace App\Http\Controllers\v1\Setup;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\v1\Controller;
use App\Http\Requests\v1\Company\IndexCompanyRequest;
use App\Repositories\v1\Setup\CompanyEventRepository;
use App\Http\Requests\v1\Company\CompanyDeleteRequest;
use App\Http\Requests\v1\Company\CompanyUpdateRequest;
use App\Http\Requests\v1\Company\DeleteCompanyRequest;
use App\Http\Requests\v1\Setup\CompanyEvent\CompanyEventGetRequest;
use App\Http\Requests\v1\Setup\CompanyEvent\CompanyEventCreateRequest;

class CompanyEventController extends Controller
{

    public function __construct(
        private readonly CompanyEventRepository $companyEventRepository
    ) {}

    public function index(IndexCompanyRequest $request): JsonResponse
    {
        $this->checkPermission('view-all-company-event');

        $validatedData = $request->validated();

        $data = $this->companyEventRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Company events fetched successfully");
    }

    public function store(CompanyEventCreateRequest $request)
    {
        $this->checkPermission('create-company-event');

        $validatedData = $request->validated();

        $create = $this->companyEventRepository->create($validatedData);

        return $this->responseSuccess($create, "Company event created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyEventGetRequest $request, $id): JsonResponse
    {
        $this->checkPermission('view-company-event');

        $request->validated();

        $find = $this->companyEventRepository->getByID($id);

        return $this->responseSuccess($find, "Company event find successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, $id)
    {
        $this->checkPermission('update-company');

        $validatedData = $request->validated();

        $update = $this->companyEventRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "Company event updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteCompanyRequest $request, $id)
    {
        $this->checkPermission('delete-company-event');

        $request->validated();

        $delete = $this->companyEventRepository->softDelete($id);

        return $this->responseSuccess($delete, "Company event deleted successfully");
    }
}
