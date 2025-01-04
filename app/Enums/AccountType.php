<?php

namespace App\Enums;

enum AccountType: int
{

    case Tenant = 1;
    case Client = 2;
    case Freelancer = 3;

    public function label(): string
    {
        return match ($this) {
            self::Tenant => 'Tenant',
            self::Client => 'Client',
            self::Freelancer => 'Freelancer',
        };
    }
}
