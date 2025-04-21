<?php

namespace App\Http\Controllers\v1\HR;

use App\Http\Controllers\v1\Controller;
use App\Repositories\v1\HR\Employee\EmployeeChildrenRepository;
use Illuminate\Http\Request;

class EmployeeChildrenController extends Controller
{
    public function __construct(private readonly EmployeeChildrenRepository $employeeChildrenRepository) {}

    public function index(Request $request)
    {
        $validatedData = $request->validated();

        $data = $this->employeeChildrenRepository->getAll($validatedData);

        return $this->responseSuccess($data, "Employees fetched successfully");
    }

}
