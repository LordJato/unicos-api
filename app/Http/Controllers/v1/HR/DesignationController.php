<?php

namespace App\Http\Controllers\v1\HR;

use App\Repositories\v1\HR\DesignationRepository;
use Illuminate\Http\Request;

class DesignationController
{
    public function __construct(private readonly DesignationRepository $designationRepository) {}
}
