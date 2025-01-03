<?php

namespace App\Http\Controllers\Setting;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Setting\DepartmentRepository;
use App\Http\Requests\Setting\Department\DepartmentGetRequest;
use App\Http\Requests\Setting\Department\DepartmentCreateRequest;
use App\Http\Requests\Setting\Department\DepartmentUpdateRequest;

class DepartmentController extends Controller
{

    public function __construct(private readonly DepartmentRepository $departmentRepository) {}

    public function index(Request $request): JsonResponse
    {
        try {
            $data = $this->departmentRepository->getAll($request->all());

            return $this->responseSuccess($data, "Department fetched successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    public function store(DepartmentCreateRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $create = $this->departmentRepository->create($validatedData);

            return $this->responseSuccess($create, "Department created successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DepartmentGetRequest $request): JsonResponse
    {
        try {

            $find = $this->departmentRepository->getByID($request->query('id'));

            return $this->responseSuccess($find, "Department find successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentUpdateRequest $request)
    {
        try {

            $update = $this->departmentRepository->update($request->query('id'), $request->all());

            return $this->responseSuccess($update, "Department updated successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }
}
