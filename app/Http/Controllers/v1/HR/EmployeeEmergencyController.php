<?php

namespace App\Http\Controllers\v1\HR;

use App\Http\Controllers\v1\Controller;
use App\Repositories\v1\HR\Employee\EmployeeEmergencyRepository;
use Illuminate\Http\Request;

class EmployeeEmergencyController extends Controller
{
    public function __construct(private readonly EmployeeEmergencyRepository $employeeEmergencyRepository) {}

    public function index(Request $request)
    {
        $validatedData = $request->validated();

        $data = $this->employeeEmergencyRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Employees fetched successfully");
    }
}
