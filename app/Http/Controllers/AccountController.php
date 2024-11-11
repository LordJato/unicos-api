<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AccountRequest;
use App\Http\Repositories\AccountRepository;

class AccountController extends Controller
{

    use ResponseTrait;

    public $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(AccountRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $data = $this->accountRepository->getAll($validated);

            return $this->responseSuccess($data, "Account fetched successfully");
        } catch (Exception $e) {
            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountRequest $request)
    {
        try {

            $create = $this->accountRepository->create($request->all());

            return $this->responseSuccess($create, "Account created successfully");
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountRequest $request): JsonResponse
    {
        try {

            $find = $this->accountRepository->getByID($request->query('id'));

            return $this->responseSuccess($find, "Account find successfully");
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountRequest $accountRequest)
    {
        try {

            $update = $this->accountRepository->update($request->id, $accountRequest->all());

            return $this->responseSuccess($update, "Account updated successfully");
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
            
            $delete = $this->accountRepository->softDelete($accountRequest->id);

            return $this->responseSuccess($delete, "Account deleted successfully");
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }
}
