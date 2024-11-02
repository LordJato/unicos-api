<?php

namespace App\Models;

use App\Traits\TenantAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    use HasFactory, SoftDeletes, TenantAccount;

    protected $fillable = [
        'account_id',
        'name',
        'address',
        'city',
        'province',
        'postal',
        'country',
        'email',
        'phone',
        'fax',
        'tin',
        'sss',
        'philhealth',
        'hdmf'
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
