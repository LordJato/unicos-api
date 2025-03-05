<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Repositories\v1\AccountRepository;
use App\Http\Requests\v1\Account\AccountIndexRequest;
use App\Http\Requests\v1\Account\AccountUpdateRequest;
use App\Http\Requests\v1\Account\AccountCreateRequest;
use App\Http\Requests\v1\Account\AccountDeleteRequest;
use App\Http\Requests\v1\Account\AccountGetRequest;

class AccountController extends Controller
{

    public function __construct(private readonly AccountRepository $accountRepository) {}

    /**
     * Display a listing of the resource.
     */
    public function index(AccountIndexRequest $request): JsonResponse
    {

        $this->checkPermission('view-all-account');

        $validatedData = $request->validated();

        $data = $this->accountRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Account fetched successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountCreateRequest $request): JsonResponse
    {
        $this->checkPermission('create-account');

        $validatedData = $request->validated();

        $create = $this->accountRepository->create($validatedData);

        return $this->responseSuccess($create, "Account created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountGetRequest $request, $id): JsonResponse
    {
        $this->checkPermission('view-account');

        $request->validated();

        $find = $this->accountRepository->getByID($id);

        return $this->responseSuccess($find, "Account find successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccountUpdateRequest $request, $id): JsonResponse
    {

        $this->checkPermission('update-account');

        $validatedData = $request->validated();

        $update = $this->accountRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "Account updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountDeleteRequest $request, $id): JsonResponse
    {
        $this->checkPermission('delete-account');

        $request->validated();

        $delete = $this->accountRepository->softDelete($id);

        return $this->responseSuccess($delete, "Account deleted successfully");
    }
}
