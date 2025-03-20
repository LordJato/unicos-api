<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'empployee_type_id',
        'empployee_status_id',
        'designation_id',
        'shift_id',
        'id_no',
        'firstname',
        'lastname',
        'middlename',
        'date_hired',
        'date_resigned',
        'date_terminated',
        'tin',
        'sss',
        'pagibig',
        'philhealth',
        'ecola',
        'basic_salary',
        'hourly_rate'
    ];
}
