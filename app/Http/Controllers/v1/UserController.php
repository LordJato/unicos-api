<?php

namespace App\Http\Controllers\v1;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Repositories\v1\UserRepository;
use App\Http\Requests\v1\User\UserGetRequest;
use App\Http\Requests\v1\User\UserCreateRequest;
use App\Http\Requests\v1\User\UserDeleteRequest;
use App\Http\Requests\v1\User\UserIndexRequest;
use App\Http\Requests\v1\User\UserUpdateRequest;
use App\Http\Requests\v1\User\UserUpdateRoleRequest;

class UserController extends Controller
{

    public function __construct(private readonly UserRepository $userRepository) {}


    public function index(UserIndexRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $data = $this->userRepository->getAll($validatedData);
         

            return $this->responseSuccess($data, "Users fetched successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $create = $this->userRepository->create($validatedData);

            return $this->responseSuccess($create, "User created successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        try {
            $find = $this->userRepository->getByID($id);

            return $this->responseSuccess(new UserResource($find), "User find successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UserUpdateRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $update = $this->userRepository->update($id, $validatedData);

            return $this->responseSuccess($update, "User updated successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $delete = $this->userRepository->softDelete($id);

            return $this->responseSuccess($delete, "User deleted successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    public function profile()
    {
        try {

            $profile = new UserResource(getCurrentUser());

            return $this->responseSuccess($profile, 'User fetched successfully');
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    public function updateRoles(UserUpdateRoleRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $user = $this->userRepository->syncRolesWithPermissions($validatedData);

            return $this->responseSuccess($user, 'User fetched successfully');
        } catch (Exception $e) {
            return $e;

            return parent::handleException($e);
        }
    }
}
