<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeChildren extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'name',
        'birth_date',
        'birth_certificate',
    ];
    
}
