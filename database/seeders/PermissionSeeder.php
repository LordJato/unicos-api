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
            ],
            [
                "name" => "View All Company",
                "slug" => "view-all-company",
            ],
            [
                "name" => "View Company",
                "slug" => "view-company",
            ],
            [
                "name" => "Create Company",
                "slug" => "create-company",
            ],
            [
                "name" => "Update Company",
                "slug" => "update-company",
            ],
            [
                "name" => "Delete Company",
                "slug" => "delete-company",
            ],
            [
                "name" => "View All Department",
                "slug" => "view-all-department",
            ],
            [
                "name" => "View Department",
                "slug" => "view-department",
            ],
            [
                "name" => "Create Department",
                "slug" => "create-department",
            ],
            [
                "name" => "Update Department",
                "slug" => "update-department",
            ],
            [
                "name" => "Delete Department",
                "slug" => "delete-department",
            ],
        ]);
    }
}
