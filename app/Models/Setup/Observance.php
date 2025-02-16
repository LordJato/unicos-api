<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observance extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'observance_type_id',
        'title',
        'description',
        'start_date',
        'end_date'
    ];
}
