<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Super Admin Account
        $user = User::create([
            "email" => "superadmin@unicos.com",
            "password" => Hash::make("password"),
        ]);

        $supderAdminRole = Role::superAdmin()->first();

        $user->roles()->attach($supderAdminRole->id);
    }
}
