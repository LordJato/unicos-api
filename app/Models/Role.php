<?php

namespace App\Models;

use App\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Role extends Model
{
    use HasFactory, HasPermissions;

    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'slug',
    ];
   
    protected $hidden = ['pivot'];
    
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions');
    }
    
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_roles');
    }

    public function scopeSuperAdmin(Builder $query)
    {
        return $query->where('slug', 'super-admin');
    }

    public function scopeAdmin(Builder $query)
    {
        return $query->where('slug', 'admin');
    }

    public function scopeHrHead(Builder $query)
    {
        return $query->where('slug', 'hr-head');
    }
}
