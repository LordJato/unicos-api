<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\User\UserGetRequest;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserDeleteRequest;
use App\Http\Requests\User\UserUpdateRequest;

class UserController extends Controller
{
    use ResponseTrait;

    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function index()
    {
        try {
            return $this->responseSuccess($this->userRepository->getAll(request()), "Users fetched successfully");
        } catch (Exception $e) {
            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        try {

            $create = $this->userRepository->create($request->all());

            return $this->responseSuccess($create, "User created successfully");
        } catch (Exception $e) {
            return $e;
            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UserGetRequest $request): JsonResponse
    {
        try {

            $find = $this->userRepository->getByID($request->query('id'));

            return $this->responseSuccess(new UserResource($find), "User find successfully");
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

        /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserUpdateRequest $updateRequest)
    {
        try {

            $update = $this->userRepository->update($request->id, $updateRequest->all());

            return $this->responseSuccess($update, "User updated successfully");
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserDeleteRequest $deleteRequest)
    {
        try {
            
            $delete = $this->userRepository->softDelete($deleteRequest->id);

            return $this->responseSuccess($delete, "User deleted successfully");
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    public function profile()
    {
        try {

            $profile = $this->userRepository->getAuthUser();

            return $this->responseSuccess($profile, 'User fetched successfully');
            
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }
}
