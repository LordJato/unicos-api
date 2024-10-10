<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Account;
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
    public function index() : JsonResponse
    {
        try {

            return $this->responseSuccess($this->accountRepository->getAll(request()), "Account fetched successfully");
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountRequest $request)
    {
        try {

            $createAccount = $this->accountRepository->create($request->all());

            return $this->responseSuccess($createAccount, "Account created successfully");
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountRequest $request) : JsonResponse
    {
        try {

            $findAccount = $this->accountRepository->getByID($request->query('id'));

            return $this->responseSuccess($findAccount, "Account find successfully");
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountRequest $accountRequest)
    {
        try {

            $accountRequest['is_active'] = $accountRequest['is_active'] ?? 0;

            $updateAccount = $this->accountRepository->update($request->id, $accountRequest->all());

            return $this->responseSuccess($updateAccount, "Account updated successfully");
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        //
    }
}
