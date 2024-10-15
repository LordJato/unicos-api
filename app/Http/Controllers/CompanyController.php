<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AccountRequest;
use App\Http\Repositories\CompanyRepository;
use App\Http\Requests\Company\CompanyGetRequest;
use App\Http\Requests\Company\CompanyIndexRequest;
use App\Http\Requests\Company\CompanyCreateRequest;
use App\Http\Requests\Company\CompanyUpdateRequest;

class CompanyController extends Controller
{

    use ResponseTrait;

    public $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(CompanyIndexRequest $request): JsonResponse
    {
        try {
            $data = $this->companyRepository->getAll($request);

            return $this->responseSuccess($data, "Company fetched successfully");
        } catch (Exception $e) {
            return $this->responseError([], $e->getMessage(), $e->getCode());
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
            return $this->responseError([], $e->getMessage(), $e->getCode());
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
         
            return $this->responseError([], $e->getMessage(), $e->getCode());
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
            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountRequest $accountRequest)
    {
        try {
            
            $delete = $this->companyRepository->softDelete($accountRequest->id);

            return $this->responseSuccess($delete, "Account deleted successfully");
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }
}
