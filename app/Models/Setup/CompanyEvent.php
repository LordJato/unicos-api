<?php

namespace App\Models\Setup;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyEvent extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'company_id',
        'title',
        'description',
        'start_date',
        'end_date'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
