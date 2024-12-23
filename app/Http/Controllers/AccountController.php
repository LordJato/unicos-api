<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AccountRequest;
use App\Http\Repositories\AccountRepository;

class AccountController extends Controller
{

    public function __construct(private AccountRepository $accountRepository) {}

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
    public function store(AccountRequest $request)
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
    public function show(AccountRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $find = $this->accountRepository->getByID($validatedData['id']);

            return $this->responseSuccess($find, "Account find successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccountRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $update = $this->accountRepository->update($validatedData['id'], $validatedData);

            return $this->responseSuccess($update, "Account updated successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $delete = $this->accountRepository->softDelete($validatedData['id']);

            return $this->responseSuccess($delete, "Account deleted successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }
}
