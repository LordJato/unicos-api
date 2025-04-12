<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\JsonResponse;
use App\Http\Resources\v1\UserResource;
use App\Repositories\v1\UserRepository;
use App\Http\Requests\v1\User\GetUserRequest;
use App\Http\Requests\v1\User\IndexUserRequest;
use App\Http\Requests\v1\User\CreateUserRequest;
use App\Http\Requests\v1\User\UpdateUserRequest;
use App\Http\Requests\v1\User\UpdateRoleUserRequest;

class UserController extends Controller
{

    public function __construct(private readonly UserRepository $userRepository) {}


    public function index(IndexUserRequest $request)
    {
        $this->checkPermission('view-all-user');

        $validatedData = $request->validated();

        $data = $this->userRepository->getAll($validatedData);


        return $this->responseSuccess($data, "Users fetched successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $this->checkPermission('create-user');

        $validatedData = $request->validated();

        $create = $this->userRepository->create($validatedData);

        return $this->responseSuccess($create, "User created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(GetUserRequest $request, int $id): JsonResponse
    {
        $this->checkPermission('view-user');

        $request->validated();

        $find = $this->userRepository->getByID($id);

        return $this->responseSuccess(new UserResource($find), "User find successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        $this->checkPermission(['update-user', 'update-role']);

        $validatedData = $request->validated();

        $update = $this->userRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "User updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->checkPermission('delete-user');

        $delete = $this->userRepository->softDelete($id);

        return $this->responseSuccess($delete, "User deleted successfully");
    }

    public function profile()
    {
        $profile = new UserResource(getCurrentUser());

        return $this->responseSuccess($profile, 'User fetched successfully');
    }

    public function updateRoles(UpdateRoleUserRequest $request)
    {
        $validatedData = $request->validated();

        $user = $this->userRepository->syncRolesWithPermissions($validatedData);

        return $this->responseSuccess($user, 'User fetched successfully');
    }
}
