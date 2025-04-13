<?php

namespace App\Http\Controllers\v1\Setup;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\v1\Controller;
use App\Repositories\v1\Setup\HolidayRepository;
use App\Http\Requests\v1\Setup\Holiday\GetHolidayRequest;
use App\Http\Requests\v1\Setup\Holiday\IndexHolidayRequest;
use App\Http\Requests\v1\Setup\Holiday\CreateHolidayRequest;
use App\Http\Requests\v1\Setup\Holiday\DeleteHolidayRequest;
use App\Http\Requests\v1\Setup\Holiday\UpdateHolidayRequest;

class HolidayController extends Controller
{

    public function __construct(
        private readonly HolidayRepository $holidayRepository
    ) {}

    public function index(IndexHolidayRequest $request): JsonResponse
    {
        $this->checkPermission('view-all-holiday');

        $validatedData = $request->validated();

        $data = $this->holidayRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Holiday fetched successfully");
    }

    public function store(CreateHolidayRequest $request)
    {
        $this->checkPermission('create-holiday');

        $validatedData = $request->validated();

        $create = $this->holidayRepository->create($validatedData);

        return $this->responseSuccess($create, "Holiday created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(GetHolidayRequest $request, $id): JsonResponse
    {
        $this->checkPermission('view-holiday');

        $request->validated();

        $find = $this->holidayRepository->getByID($id);

        return $this->responseSuccess($find, "Holiday find successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHolidayRequest $request, $id)
    {
        $this->checkPermission('update-holiday');

        $validatedData = $request->validated();

        $update = $this->holidayRepository->update($id, $validatedData);

        return $this->responseSuccess($update, "Holiday updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteHolidayRequest $request, $id)
    {
        $this->checkPermission('delete-holiday');

        $request->validated();

        $delete = $this->holidayRepository->softDelete($id);

        return $this->responseSuccess($delete, "Holiday deleted successfully");
    }
}
