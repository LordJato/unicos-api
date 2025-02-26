<?php

namespace App\Traits;

use App\Models\Permission;
use Illuminate\Support\Arr;

trait HasPermissions
{
    /**
     * Check if the model has the given permissions directly or through roles.
     *
     * @param mixed ...$permissions
     * @return bool
     */

    public function hasPermissionTo(...$permissions) : bool
    {
        return $this->permissions()->whereIn('slug', $permissions)->exists() ||
            $this->roles()->whereHas('permissions', function ($query) use ($permissions) {
                $query->whereIn('slug', $permissions);
            })->exists();
    }

    /**
     * Attach the given permissions to the model.
     *
     * @param mixed ...$permissions
     * @return void
     */

    public function givePermissionTo(...$permissions): void
    {
        $this->permissions()->attach($this->getPermissionIdsBySlug(...$permissions));
    }

    /**
     * Sync the given permissions with the model.
     *
     * @param mixed ...$permissions
     * @return void
     */

    public function setPermissions(...$permissions)
    {
        $this->permissions()->sync($this->getPermissionIdsBySlug($permissions));
    }

    /**
     * Sync the given permissions with the model without detaching existing permissions.
     *
     * @param mixed ...$permissions
     * @return void
     */

    public function setPermissionsWihtoutDetaching(...$permissions): void
    {
        $this->permissions()->syncWithoutDetaching($this->getPermissionIdsBySlug($permissions));
    }

    /**
     * Detach the given permissions from the model.
     *
     * @param mixed ...$permissions
     * @return void
     */

    public function detachPermissions(...$permissions): void
    {
        $this->permissions()->detach($this->getPermissionIdsBySlug($permissions));
    }

    /**
     * Get permission IDs by their slugs.
     *
     * @param array $permissions
     * @return array
     */
    private function getPermissionIdsBySlug($permissions): array
    {
        $permissions = is_array($permissions) ? Arr::flatten($permissions) : [$permissions];

        return Permission::whereIn('slug', $permissions)->pluck('id')->toArray();
    }

    /**
     * Get all permission IDs associated with the given roles.
     *
     * @param array $roles
     * @return \Illuminate\Support\Collection
     */
    public function getAllPermissionIdByRoles($roles)
    {
        return Permission::whereHas('roles', function ($query) use ($roles) {
            $query->whereIn('id', $roles);
        })->pluck('id');
    }
}
