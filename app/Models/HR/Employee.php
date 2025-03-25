<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function designation() : BelongsTo {

        return $this->belongsTo(Designation::class);
    }

    public function employeeStatus() : BelongsTo {
        
        return $this->belongsTo(EmployeeStatus::class);
    }

    
    public function employeeType() : BelongsTo {
        
        return $this->belongsTo(EmployeeType::class);
    }

    public function shift() : BelongsTo {
        
        return $this->belongsTo(ShiftHeader::class);
    }
}
