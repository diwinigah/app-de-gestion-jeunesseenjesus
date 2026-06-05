<?php

declare(strict_types=1);

namespace App\Enums;

enum ProjectInvestorInterestStatus: string
{
    case New = 'new';
    case Contacted = 'contacted';
    case Pledged = 'pledged';
    case Paid = 'paid';
    case Cancelled = 'cancelled';
}
