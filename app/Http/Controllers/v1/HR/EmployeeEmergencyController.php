<?php

namespace App\Http\Controllers\v1\HR;

use App\Repositories\v1\HR\Employee\EmployeeEmergencyRepository;
use Illuminate\Http\Request;

class EmployeeEmergencyController
{
    public function __construct(private readonly EmployeeEmergencyRepository $employeeEmergencyRepository) {}
}
