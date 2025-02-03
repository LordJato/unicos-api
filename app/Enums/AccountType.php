<?php

namespace App\Enums;

enum AccountType: int
{

    case Tenant = 1;
    case Company = 2;
    case Client = 3;
    case Employee = 4;
    case Freelancer = 5;

    public function label(): string
    {
        return match ($this) {
            self::Tenant => 'Tenant',
            self::Company => 'Company',
            self::Client => 'Client',
            self::Employee => 'Employee',
            self::Freelancer => 'Freelancer',
        };
    }
}
