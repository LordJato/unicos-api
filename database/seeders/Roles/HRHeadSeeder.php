<?php

namespace Database\Seeders\Roles;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HRHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
            'view-all-employee',
            'view-employee',
            'create-employee',
            'update-employee',
            'delete-employee',
        ];

        $hrRole = Role::create(['name' => 'HR Head', 'slug' => 'hr-head']);

        $hrRole->setPermissionsWihtoutDetaching($permissions);

    }
}
