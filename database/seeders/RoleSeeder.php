<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seed
    {
    public function run(): void
    {
        Role::insert([
            [
                "name" => "Super Admin",
                "slug" => "super-admin",
            ],
            [
                "name" => "Admin",
                "slug" => "admin",
            ],
            [
                "name" => "User",
                "slug" => "user",
            ],
            [
                "name" => "Employee",
                "slug" => "employee",
            ],
        ]);
    }
}
