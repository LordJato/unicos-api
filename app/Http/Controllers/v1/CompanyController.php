<?php

namespace App\Http\Controllers\v1;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use App\Repositories\v1\CompanyRepository;
use App\Http\Requests\v1\Company\CompanyIndexRequest;
use App\Http\Requests\v1\Company\CompanyCreateRequest;
use App\Http\Requests\v1\Company\CompanyUpdateRequest;

class CompanyController extends Controller
{

    public function __construct(private readonly CompanyRepository $companyRepository) {}

    /**
     * Display a listing of the resource.
     */
    public function index(CompanyIndexRequest $request): JsonResponse
    {
        $this->checkPermission('view-all-company');

        $validatedData = $request->validated();

        $data = $this->companyRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Company fetched successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {
        $this->checkPermission('create-company');

        $validatedData = $request->validated();

        $create = $this->companyRepository->create($validatedData);

        return $this->responseSuccess($create, "Company created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $this->checkPermission('view-company');

        $find = $this->companyRepository->getByID($id);

        return $this->responseSuccess($find, "Company find successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, CompanyUpdateRequest $request)
    {
        $this->checkPermission('update-company');

        $validatedData = $request->validated();

        $update = $this->companyRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "Company updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->checkPermission('delete-company');

        $delete = $this->companyRepository->softDelete($id);

        return $this->responseSuccess($delete, "Company deleted successfully");
    }
}
