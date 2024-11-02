<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Repositories\RoleRepository;
use App\Http\Requests\Role\RoleGetRequest;
use App\Http\Requests\Role\RoleIndexRequest;
use App\Http\Requests\Role\RoleCreateRequest;
use App\Http\Requests\Role\RoleDeleteRequest;
use App\Http\Requests\Role\RoleUpdateRequest;

class RoleController extends Controller
{
    use ResponseTrait;

    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index(RoleIndexRequest $request) : JsonResponse
    {
        try {
            $data = $this->roleRepository->getAll($request);

            return $this->responseSuccess($data, "Roles fetched successfully");
        } catch (Exception $e) {
            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    public function show(RoleGetRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $find = $this->roleRepository->getById($validatedData['id']);

            return $this->responseSuccess($find, "Role find successfully");
        } catch (Exception $e) {

            return $e;

            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }


    public function store(RoleCreateRequest $request)
    {
        try {

            $validatedData = $request->validated();

            $create = $this->roleRepository->create($validatedData);

            return $this->responseSuccess($create, "Role created successfully");
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    public function update(RoleUpdateRequest $request)
    {
        try {

            $validatedData = $request->validated();

            $update = $this->roleRepository->update($validatedData);

            return $this->responseSuccess($update, "Role updated successfully");
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    public function destroy(RoleDeleteRequest $request)
    {
        try {

            $validatedData = $request->validated();

            $role = Role::where('id', $validatedData['id'])->delete();

            return $this->responseSuccess($role, "Role deleted successfully");
        } catch (Exception $e) {

            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    public function attachPermissions(Request $request){
        try {

            $role = $this->roleRepository->getByID($request->roleID);

            $permissions = Permission::whereIn('slug', $request->permissions)->get()->pluck('id')->toArray();

            $attach = $role->permissions()->attach($permissions);

            return $this->responseSuccess($attach, "Permissions attached successfully.");
        } catch (Exception $e) {

            return $e;
            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }

    public function rolesPermissions()
    {
        try {
            return $this->responseSuccess(Role::with('permissions')->get(), "Roles fetched successfully");
        } catch (Exception $e) {
            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }
}
