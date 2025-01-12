<?php

namespace App\Http\Controllers\Setting;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Setting\ObservanceRepository;
use App\Http\Requests\Setting\Observance\ObservanceIndexRequest;

class ObservanceController extends Controller
{
    public function __construct(
        private readonly ObservanceRepository $observanceRepository,
    ) {}

    public function index(ObservanceIndexRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $data = $this->observanceRepository->getAll($validatedData);

            return $this->responseSuccess($data, "Observance fetched successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validated();

            $create = $this->observanceRepository->create($validatedData);

            return $this->responseSuccess($create, "Observance created successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $find = $this->observanceRepository->getByID($validatedData['id']);

            return $this->responseSuccess($find, "Observance find successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $validatedData = $request->validated();

            $update = $this->observanceRepository->update($validatedData);

            return $this->responseSuccess($update, "Observance updated successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $validatedData = $request->validated();

            $delete = $this->observanceRepository->softDelete($validatedData);

            return $this->responseSuccess($delete, "Observance deleted successfully");
        } catch (Exception $e) {

            return parent::handleException($e);
        }
    }
}
