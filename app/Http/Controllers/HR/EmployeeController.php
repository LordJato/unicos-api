<?php

namespace App\Http\Controllers\HR;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Repositories\HR\EmployeeRepository;
use App\Http\Requests\HR\Employee\EmployeeIndexRequest;

class EmployeeController extends Controller
{
    use ResponseTrait;

    public $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }


    public function index(EmployeeIndexRequest $request)
    {
        try {
            $data = $this->employeeRepository->getAll($request);

            return $this->responseSuccess($data, "Employees fetched successfully");
        } catch (Exception $e) {
            return $this->responseError([], $e->getMessage(), $e->getCode());
        }
    }
}
