<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeEmergency extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'contact_no',
        'contact_person',
        'relationship',
    ];
}
