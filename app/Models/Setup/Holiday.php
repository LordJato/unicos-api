<?php

namespace App\Models\Setup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'compastart_dateny_id',
        'end_date'
    ];
}
