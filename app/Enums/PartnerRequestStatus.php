<?php

declare(strict_types=1);

namespace App\Enums;

enum PartnerRequestStatus: string
{
    case New = 'new';
    case Reviewed = 'reviewed';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
    case Archived = 'archived';
}
