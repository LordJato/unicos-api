<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'opportunity_type_id',
        'opportunity_status_id',
        'designation_id',
        'career_level_id',
        'title',
        'slug',
        'description',
        'commitment',
        'years_of_experience',
        'count',
    ];
}
