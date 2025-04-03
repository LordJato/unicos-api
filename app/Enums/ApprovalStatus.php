<?php

namespace App\Enums;

enum ApprovalStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case IN_REVIEW = 'in_review';
    case NEEDS_REVISION = 'needs_revision';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::IN_REVIEW => 'In Review',
            self::NEEDS_REVISION => 'Needs Revision',
            self::CANCELLED => 'Cancelled',
        };
    }
}
