<?php

namespace App\Models\Recruitment;

use App\Traits\TenantCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Opportunity extends Model
{
    use HasFactory, TenantCompany;

    protected $fillable = [
        'company_id',
        'opportunity_type_id',
        'opportunity_status_id',
        'designation_id',
        'career_level_id',
        'title',
        'slug',
        'description',
        'location',
        'schedule',
        'years_of_experience',
        'vacancy',
    ];

    public function benefits(): HasMany
    {
        return $this->hasMany(OpportunityBenefit::class);
    }

    public function requirements(): HasMany
    {
        return $this->hasMany(OpportunityRequirement::class);
    }

    public function responsibilites(): HasMany
    {
        return $this->hasMany(OpportunityResponsibility::class);
    }
}
