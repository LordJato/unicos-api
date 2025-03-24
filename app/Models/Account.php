<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_type_id',
        'name'
    ];

    public function accountType() : BelongsTo {

        return $this->belongsTo(AccountType::class);
    }
}
