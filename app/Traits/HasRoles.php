<?php

namespace App\Traits;

use App\Models\Role;
use RuntimeException;
use InvalidArgumentException;

trait HasRoles
{
    public function hasRolesTo(...$roles)
    {
        return $this->roles()->whereIn('slug', $roles)->count() ||
        $this->permissions()->whereHas('roles', function ($q) use ($roles) {
            $q->whereIn('slug', $roles);
        })->count();
    }

    public function giveRolesTo(...$roles) 
    {
        $this->roles()->attach($this->getRoleIds($roles));
    }

    public function setRoles(...$roles)
    {
        $this->roles()->sync($this->getRoleIds($roles));
    }

    public function detachRoles(...$roles)
    {
        $this->roles()->detach($this->getRoleIds($roles));
    }

    private function getRoleIds(array $roles): array
    {
        if (!is_array($roles)) {
            throw new InvalidArgumentException('Roles must be an array');
        }
    
        if (array_reduce($roles, function ($carry, $item) {
            return $carry && is_int($item);
        }, true)) {
            return $roles;
        }
    
        $roleIds = Role::whereIn('slug', $roles)->pluck('id')->values()->all();
    
        if (count($roleIds) !== count($roles)) {
            throw new RuntimeException('Some roles not found');
        }
    
        return $roleIds;
    }
}
