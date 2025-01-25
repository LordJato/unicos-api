<?php

namespace App\Enums;

/**
 * Enum for different career levels.
 */
enum CareerLevel: int
{
    /**
     * OJT (On-the-Job Training) career level.
     */
    case OJT = 1;

    /**
     * Intern career level.
     */
    case Intern = 2;

    /**
     * Entry-level career level.
     */
    case EntryLevel = 3;

    /**
     * Mid-level career level.
     */
    case MidLevel = 4;

    /**
     * Senior career level.
     */
    case Senior = 5;

    /**
     * Executive career level.
     */
    case Executive = 6;

    /**
     * Manager career level.
     */
    case Manager = 7;

    /**
     * Director career level.
     */
    case Director = 8;

    /**
     * Get a human-readable label for the career level.
     */
    public function label(): string
    {
        return match ($this) {
            self::OJT => 'OJT (On-the-Job Training)',
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