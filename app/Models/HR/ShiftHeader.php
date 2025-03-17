<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftHeader extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'name',
        'grace_period',
        'lunch_break',
    ];
}
