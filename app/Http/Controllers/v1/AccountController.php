<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\v1\AccountResource;
use App\Repositories\v1\AccountRepository;
use App\Http\Requests\v1\Account\AccountGetRequest;
use App\Http\Requests\v1\Account\GetAccountRequest;
use App\Http\Requests\v1\Account\IndexAccountRequest;
use App\Http\Requests\v1\Account\AccountDeleteRequest;
use App\Http\Requests\v1\Account\AccountUpdateRequest;
use App\Http\Requests\v1\Account\CreateAccountRequest;
use App\Http\Requests\v1\Account\DeleteAccountRequest;
use App\Http\Requests\v1\Account\UpdateAccountRequest;

class AccountController extends Controller
{

    public function __construct(private readonly AccountRepository $accountRepository) {}

    /**
     * Display a listing of the resource.
     */
    public function index(IndexAccountRequest $request): JsonResponse
    {

        $this->checkPermission('view-all-account');

        $validatedData = $request->validated();

        $data = $this->accountRepository->getAll($validatedData);
        
        $data['records'] = AccountResource::collection($data['records']);

        return $this->responseSuccess($data, "Account fetched successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAccountRequest $request): JsonResponse
    {
        $this->checkPermission('create-account');

        $validatedData = $request->validated();

        $create = $this->accountRepository->create($validatedData);

        return $this->responseSuccess(new AccountResource($create), "Account created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(GetAccountRequest $request, $id): JsonResponse
    {
        $this->checkPermission('view-account');

        $request->validated();

        $find = $this->accountRepository->getByID($id);

        return $this->responseSuccess(new AccountResource($find), "Account found successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, $id): JsonResponse
    {

        $this->checkPermission('update-account');

        $validatedData = $request->validated();

        $update = $this->accountRepository->update($id, $validatedData);

        return $this->responseSuccess(new AccountResource($update), "Account updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteAccountRequest $request, $id): JsonResponse
    {
        $this->checkPermission('delete-account');

        $request->validated();

        $delete = $this->accountRepository->softDelete($id);

        return $this->responseSuccess($delete, "Account deleted successfully");
    }

        /**
     * Remove the specified resource from storage.
     */
    public function showAllAccountType(): JsonResponse
    {
        $data = $this->accountRepository->getAllAccountType();

        return $this->responseSuccess($data, "Account types fetched successfully");
    }
}
