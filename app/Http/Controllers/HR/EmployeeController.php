<?php

namespace App\Http\Controllers\HR;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Repositories\HR\EmployeeRepository;
use App\Http\Requests\HR\Employee\EmployeeIndexRequest;

class EmployeeController extends Controller
{
    public function __construct(private readonly EmployeeRepository $employeeRepository)
    {}


    public function index(EmployeeIndexRequest $request)
    {
        try {
            $data = $this->employeeRepository->getAll($request);

            return $this->responseSuccess($data, "Employees fetched successfully");
        } catch (Exception $e) {
            return parent::handleException($e);
        }
    }
}
