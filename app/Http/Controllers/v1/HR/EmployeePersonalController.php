<?php

namespace App\Http\Controllers\v1\HR;

use App\Http\Controllers\v1\Controller;
use App\Repositories\v1\HR\Employee\EmployeePersonalRepository;
use Illuminate\Http\Request;

class EmployeePersonalController extends Controller
{
    public function __construct(private readonly EmployeePersonalRepository $employeePersonalRepository) {}

    public function index(Request $request)
    {
        $validatedData = $request->validated();

        $data = $this->employeePersonalRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Employees fetched successfully");
    }

}
