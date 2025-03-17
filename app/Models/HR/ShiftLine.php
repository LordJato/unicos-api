<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_header_id',
        'day',
        'start',
        'end',
        'is_flexi_time',
    ];
}
