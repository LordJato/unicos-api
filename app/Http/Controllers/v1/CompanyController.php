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
        try {
            $validatedData = $request->validated();
            $data = $this->companyRepository->getAll($validatedData);

            return $this->responseSuccess($data, "Company fetched successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $create = $this->companyRepository->create($validatedData);

            return $this->responseSuccess($create, "Company created successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        if (!Gate::allows('view-company')) {
            return  $this->responseError([], "This action is unauthorized", Response::HTTP_FORBIDDEN);
        }

        try {
            $find = $this->companyRepository->getByID($id);

            return $this->responseSuccess($find, "Company find successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, CompanyUpdateRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $update = $this->companyRepository->update($id, $validatedData);

            return $this->responseSuccess($update, "Company updated successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!Gate::allows('delete-company')) {
            return  $this->responseError([], "This action is unauthorized", Response::HTTP_FORBIDDEN);
        }

        try {
            $delete = $this->companyRepository->softDelete($id);

            return $this->responseSuccess($delete, "Company deleted successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }
}
