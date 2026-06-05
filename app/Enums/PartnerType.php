<?php

declare(strict_types=1);

namespace App\Enums;

enum PartnerType: string
{
    case Church = 'church';
    case Company = 'company';
    case Association = 'association';
    case Individual = 'individual';
    case Other = 'other';
}
