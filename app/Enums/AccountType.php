<?php

namespace App\Enums;

enum AccountType: int
{

    case TENANT = 1;
    case COMPANY = 2;
    case CLIENT = 3;
    case EMPLOYEE = 4;
    case QUESTOR = 5;

    public function label(): string
    {
        return match ($this) {
            self::TENANT => 'Tenant',
            self::COMPANY => 'Company',
            self::CLIENT => 'Client',
            self::EMPLOYEE => 'Employee',
            self::QUESTOR => 'Questor',
        };
    }
}
