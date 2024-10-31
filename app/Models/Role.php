<?php

namespace App\Models;

use App\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Role extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    use HasFactory, HasPermissions;

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions');
    }

    public function scopeSuperAdmin(Builder $query)
    {
        return $query->where('slug', 'super-admin');
    }
}
