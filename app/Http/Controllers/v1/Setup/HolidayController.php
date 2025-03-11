<?php

namespace App\Http\Controllers\v1\Setup;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\v1\Controller;
use App\Repositories\v1\Setup\HolidayRepository;

class CompanyeEventController extends Controller
{

    public function __construct(
        private readonly HolidayRepository $holidayRepository
    ) {}

    public function index(Request $request): JsonResponse
    {
        $this->checkPermission('view-all-holiday');

        $validatedData = $request->validated();

        $data = $this->holidayRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Holiday fetched successfully");
    }

    public function store(Request $request)
    {
        $this->checkPermission('create-holiday');

        $validatedData = $request->validated();

        $create = $this->holidayRepository->create($validatedData);

        return $this->responseSuccess($create, "Holiday created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id): JsonResponse
    {
        $this->checkPermission('view-holiday');

        $request->validated();

        $find = $this->holidayRepository->getByID($id);

        return $this->responseSuccess($find, "Holiday find successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->checkPermission('update-holiday');

        $validatedData = $request->validated();

        $update = $this->holidayRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "Holiday updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $this->checkPermission('delete-holiday');

        $request->validated();

        $delete = $this->holidayRepository->softDelete($id);

        return $this->responseSuccess($delete, "Holiday deleted successfully");
    }
}
