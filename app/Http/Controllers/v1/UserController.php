<?php

namespace App\Http\Controllers\v1;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\v1\UserResource;
use App\Repositories\v1\UserRepository;
use App\Http\Requests\v1\User\UserCreateRequest;
use App\Http\Requests\v1\User\UserIndexRequest;
use App\Http\Requests\v1\User\UserUpdateRequest;
use App\Http\Requests\v1\User\UserUpdateRoleRequest;

class UserController extends Controller
{

    public function __construct(private readonly UserRepository $userRepository) {}


    public function index(UserIndexRequest $request)
    {
        $validatedData = $request->validated();
        $data = $this->userRepository->getAll($validatedData);


        return $this->responseSuccess($data, "Users fetched successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        $validatedData = $request->validated();

        $create = $this->userRepository->create($validatedData);

        return $this->responseSuccess($create, "User created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $find = $this->userRepository->getByID($id);

        return $this->responseSuccess(new UserResource($find), "User find successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, UserUpdateRequest $request)
    {
        $validatedData = $request->validated();

        $update = $this->userRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "User updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $delete = $this->userRepository->softDelete($id);

        return $this->responseSuccess($delete, "User deleted successfully");
    }

    public function profile()
    {
        $profile = new UserResource(getCurrentUser());

        return $this->responseSuccess($profile, 'User fetched successfully');
    }

    public function updateRoles(UserUpdateRoleRequest $request)
    {
        $validatedData = $request->validated();

        $user = $this->userRepository->syncRolesWithPermissions($validatedData);

        return $this->responseSuccess($user, 'User fetched successfully');
    }
}
