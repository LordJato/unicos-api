<?php

namespace App\Enums;

enum ObservanceType: int
{

    case Holiday = 1;
    case Event = 2;

    public function label(): string
    {
        return match ($this) {
            self::Holiday => 'Holiday',
            self::Event => 'Event',
        };
    }
}
