<?php

namespace App\Enums;

/**
 * Enum for different career levels.
 */
enum CareerLevel: int
{
    /**
     * Intern career level.
     */
    case Intern = 1;

    /**
     * Entry-level career level.
     */
    case EntryLevel = 2;

    /**
     * Mid-level career level.
     */
    case MidLevel = 3;

    /**
     * Senior career level.
     */
    case Senior = 4;

    /**
     * Executive career level.
     */
    case Executive = 5;

    /**
     * Manager career level.
     */
    case Manager = 6;

    /**
     * Director career level.
     */
    case Director = 7;

    /**
     * Get a human-readable label for the career level.
     */
    public function label(): string
    {
        return match ($this) {
            self::Intern => 'Intern',
            self::EntryLevel => 'Entry-Level',
            self::MidLevel => 'Mid-Level',
            self::Senior => 'Senior',
            self::Executive => 'Executive',
            self::Manager => 'Manager',
            self::Director => 'Director',
        };
    }
}