<?php

namespace App\Http\Controllers\v1\HR;

use App\Http\Controllers\v1\Controller;
use App\Repositories\v1\HR\DesignationRepository;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function __construct(private readonly DesignationRepository $designationRepository) {}

    public function index(Request $request)
    {
        $validatedData = $request->validated();

        $data = $this->designationRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Designation fetched successfully");
    }

    public function store(Request $request)
    {
        $validatedData = $request->validated();

        $create = $this->designationRepository->create($validatedData);

        return $this->responseSuccess($create, "Designation created successfully");
    }
}
