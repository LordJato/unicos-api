<?php

namespace Database\Seeders\Roles;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::admin()->first();

        $permissions = [
            'view-all-company',
            'view-company',
            'create-company',
            'update-company',
            'delete-company',
            'view-all-user',
            'view-user',
            'create-user',
            'update-user',
            'delete-user',
            'view-all-department',
            'view-department',
            'create-department',
            'update-department',
            'delete-department',
        ];

        $adminRole->setPermissionsWihtoutDetaching($permissions);
    }
}
