<?php

namespace App\Http\Controllers\v1\HR;

use App\Repositories\v1\HR\Employee\EmployeePersonalRepository;
use Illuminate\Http\Request;

class EmployeePersonalController
{
    public function __construct(private readonly EmployeePersonalRepository $employeePersonalRepository) {}
}
