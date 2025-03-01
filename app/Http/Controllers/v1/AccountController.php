<?php

namespace App\Http\Controllers\v1;

use App\Http\Requests\v1\Account\AccountCreateRequest;
use App\Http\Requests\v1\Account\AccountDeleteRequest;
use App\Http\Requests\v1\Account\AccountGetRequest;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\v1\AccountRequest;
use App\Repositories\v1\AccountRepository;
use App\Http\Requests\v1\Account\AccountIndexRequest;
use App\Http\Requests\v1\Role\AccountUpdateRequest;

class AccountController extends Controller
{

    public function __construct(private readonly AccountRepository $accountRepository) {}

    /**
     * Display a listing of the resource.
     */
    public function index(AccountIndexRequest $request): JsonResponse
    {
        try {

            Gate::authorize('view-all-account');

            $validatedData = $request->validated();

            $data = $this->accountRepository->getAll($validatedData);

            return $this->responseSuccess($data, "Account fetched successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountCreateRequest $request): JsonResponse
    {
        try {

            Gate::authorize('create-account');

            $validatedData = $request->validated();

            $create = $this->accountRepository->create($validatedData);

            return $this->responseSuccess($create, "Account created successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountGetRequest $request, $id): JsonResponse
    {
        try {

            Gate::authorize('view-account');

            $request->validated();
            
            $find = $this->accountRepository->getByID($id);

            return $this->responseSuccess($find, "Account find successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccountUpdateRequest $request, $id): JsonResponse
    {
        try {

            Gate::authorize('update-account');

            $validatedData = $request->validated();

            $update = $this->accountRepository->update($id, $validatedData);

            return $this->responseSuccess($update, "Account updated successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountDeleteRequest $request, $id): JsonResponse
    {
        try {
            
            Gate::authorize('delete-account');

            $request->validated();

            $delete = $this->accountRepository->softDelete($id);

            return $this->responseSuccess($delete, "Account deleted successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }
}
