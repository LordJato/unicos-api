<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Repositories\CompanyRepository;
use App\Http\Requests\Company\CompanyGetRequest;
use App\Http\Requests\Company\CompanyIndexRequest;
use App\Http\Requests\Company\CompanyCreateRequest;
use App\Http\Requests\Company\CompanyDeleteRequest;
use App\Http\Requests\Company\CompanyUpdateRequest;

class CompanyController extends Controller
{

    public function __construct(private CompanyRepository $companyRepository)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index(CompanyIndexRequest $request): JsonResponse
    {
        try {
            // $validatedData = $request->validated();
            $data = $this->companyRepository->getAll($request->all());

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

            $create = $this->companyRepository->create($request->all());

            return $this->responseSuccess($create, "Company created successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyGetRequest $request): JsonResponse
    {
        try {

            $find = $this->companyRepository->getByID($request->query('id'));

            return $this->responseSuccess($find, "Company find successfully");
        } catch (Exception $e) {
         
            return parent::handleException($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CompanyUpdateRequest $companyRequest)
    {
        try {

            $update = $this->companyRepository->update($request->query('id'), $companyRequest->all());
    
            return $this->responseSuccess($update, "Company updated successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyDeleteRequest $request)
    {
        try {
            $delete = $this->companyRepository->softDelete($request->id);

            return $this->responseSuccess($delete, "Company deleted successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }
}
