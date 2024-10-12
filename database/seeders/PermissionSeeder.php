<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insert([
            [
                "name" => "View Account Dashboard",
                "slug" => "view-account-dashboard",
            ],
            [
                "name" => "View All Account",
                "slug" => "view-all-account",
            ],
            [
                "name" => "View Account",
                "slug" => "view-account",
            ],
            [
                "name" => "Create Account",
                "slug" => "create-account",
            ],
            [
                "name" => "Update Account",
                "slug" => "update-account",
            ],
            [
                "name" => "Delete Account",
                "slug" => "delete-account",
            ]
        ]);
    }
}
