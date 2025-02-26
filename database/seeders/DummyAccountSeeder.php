<?php

namespace Database\Seeders;

use App\Enums\AccountType;
use App\Models\Role;
use App\Models\User;
use App\Models\Account;
use App\Models\Company;
use App\Models\Setup\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DummyAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Account
        $account = Account::create([
            'name' => 'Dummy Account',
            'account_type_id' => AccountType::Tenant
        ]);

        $account2 = Account::create([
            'name' => 'Dummy Account 2',
            'account_type_id' => AccountType::Tenant
        ]);


        //User
        $admin = User::create([
            "email" => "dummyadmin@unicos.com",
            "password" => Hash::make("password"),
            'account_id' => $account->id
        ]);

        $admin2 = User::create([
            "email" => "dummyadmin2@unicos.com",
            "password" => Hash::make("password"),
            'account_id' => $account->id
        ]);

        $adminRole = Role::admin()->first();

        $admin->roles()->attach($adminRole->id);
        $admin2->roles()->attach($adminRole->id);
       

        //Company
        $companyA = Company::create(
            [
                "account_id" => $account->id,
                "name" => "Dummy Company",
                "address" => "Dummy Company Address",
                "city" => "Dummy Company City",
                "province" => "Dummy Company Province",
                "postal" => "6100",
                "country" => "Dummy Company Country",
                "email" => "dummycompany@unicos.com",
                "phone" => "09812931235",
                "fax" => "1251",
                "tin" => "3453453451",
                "sss" => "1982379182",
                "philhealth" => "1645634534",
                "hdmf" => "678678678"
            ]
        );

        $companyA2 =  Company::create(
            [
                "account_id" => $account->id,
                "name" => "Dummy 2 Company",
                "address" => "Dummy 2 Company Address",
                "city" => "Dummy 2 Company City",
                "province" => "Dummy 2 Company Province",
                "postal" => "6100",
                "country" => "Dummy 2 Company Country",
                "email" => "dummy2companyA@unicos.com",
                "phone" => "0912311235345",
                "fax" => "3455",
                "tin" => "678678678678",
                "sss" => "123456456456",
                "philhealth" => "756678678678",
                "hdmf" => "13143534534"
            ]
        );

        $companyB = Company::create(
            [
                "account_id" => $account2->id,
                "name" => "Dummy Company B",
                "address" => "Dummy Company Address B",
                "city" => "Dummy Company City B",
                "province" => "Dummy Company Province B",
                "postal" => "6100",
                "country" => "Dummy Company Country",
                "email" => "dummycompanyB@unicos.com",
                "phone" => "09812931235",
                "fax" => "1251",
                "tin" => "3453453451",
                "sss" => "1982379182",
                "philhealth" => "1645634534",
                "hdmf" => "678678678"
            ]
        );

        $companyB2 =  Company::create(
            [
                "account_id" => $account2->id,
                "name" => "Dummy 2 Company B2",
                "address" => "Dummy 2 Company Address B2",
                "city" => "Dummy 2 Company City",
                "province" => "Dummy 2 Company Province B2",
                "postal" => "6100",
                "country" => "Dummy 2 Company Country",
                "email" => "dummy2companyB@unicos.com",
                "phone" => "0912311235345",
                "fax" => "3455",
                "tin" => "678678678678",
                "sss" => "123456456456",
                "philhealth" => "756678678678",
                "hdmf" => "13143534534"
            ]
        );

        $hr = User::create([
            "email" => "dummyhrhead@unicos.com",
            "password" => Hash::make("password"),
            'account_id' => $account->id,
            'company_id' => $companyA->id,
        ]);

        $hr2 = User::create([
            "email" => "dummyhrheadb@unicos.com",
            "password" => Hash::make("password"),
            'account_id' => $account->id,
            'company_id' => $companyB->id,
        ]);

        $hrHeadRole = Role::hrHead()->first();

        $hr->roles()->attach($hrHeadRole->id);
        $hr2->roles()->attach($hrHeadRole->id);

        //Department
        $companyADepartment = Department::create(
            [
                'company_id' => $companyA->id,
                'name' => 'HR Department' 
            ]
        );

        $companyBDepartment = Department::create(
            [
                'company_id' => $companyB->id,
                'name' => 'IT Department' 
            ]
        );

    }
}
