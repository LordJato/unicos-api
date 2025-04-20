<?php

namespace App\Http\Controllers\v1\HR;

use App\Repositories\v1\HR\Employee\EmployeeChildrenRepository;
use Illuminate\Http\Request;

class EmployeeChildrenController
{
    public function __construct(private readonly EmployeeChildrenRepository $employeeChildrenRepository) {}
}
