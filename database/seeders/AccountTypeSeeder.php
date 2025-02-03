<?php

namespace Database\Seeders;

use App\Models\AccountType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AccountType::insert([
            ['name' => 'Tenant', 'slug' => 'tenant'],
            ['name' => 'Company', 'slug' => 'company'],
            ['name' => 'Client', 'slug' => 'client'],
            ['name' => 'Freelancer', 'slug' => 'freelancer'],
            ['name' => 'Employee', 'slug' => 'employee'],
        ]);
    }
}
