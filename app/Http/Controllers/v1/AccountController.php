<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\AccountRequest;
use App\Repositories\v1\AccountRepository;

class AccountController extends Controller
{

    public function __construct(private readonly AccountRepository $accountRepository) {}

    /**
     * Display a listing of the resource.
     */
    public function index(AccountRequest $request): JsonResponse
    {
        try {
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
    public function store(AccountRequest $request): JsonResponse
    {
        try {
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
    public function show($id): JsonResponse
    {
        if (!Gate::allows('view-account')) {
            return  $this->responseError([], "This action is unauthorized", Response::HTTP_FORBIDDEN);
        }

        try {

            $find = $this->accountRepository->getByID($id);

            return $this->responseSuccess($find, "Account find successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, AccountRequest $request): JsonResponse
    {
        try {
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
    public function destroy($id): JsonResponse
    {
        if (!Gate::allows('delete-account')) {
            return  $this->responseError([], "This action is unauthorized", Response::HTTP_FORBIDDEN);
        }

        try {
            $delete = $this->accountRepository->softDelete($id);

            return $this->responseSuccess($delete, "Account deleted successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }
}
