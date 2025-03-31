<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePersonal extends Model
{
    use HasFactory;


    protected $fillable = [
        'employee_id',
        'civil_status_id',
        'birth_date',
        'birth_place',
        'sex',
        'citizenship',
        'nationality',
        'religion',
        'phone',
        'email',
        'spouse',
        'spouse_occupation',
        'mother',
        'mother_occupation',
        'father',
        'father_occupation',
    ];
}
