<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Recruitment\OpportunityRepository;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    public function __construct(private readonly OpportunityRepository $opportunityRepository) {}
}
