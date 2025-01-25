<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpportunityBenefit extends Model
{
    use HasFactory;
   
    protected $fillable = [
        'opportunity_id',
        'description',
    ];
}
