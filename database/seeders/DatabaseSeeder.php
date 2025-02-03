<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Roles\AdminPermissionSeeder;
use Database\Seeders\Roles\HRHeadSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AdminPermissionSeeder::class);
        $this->call(HRHeadSeeder::class);
        $this->call(AccountTypeSeeder::class);
        $this->call(DummyAccountSeeder::class);
    }
}
