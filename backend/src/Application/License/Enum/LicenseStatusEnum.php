<?php

declare(strict_types=1);

namespace App\Application\License\Enum;

enum LicenseStatusEnum: string
{
    case Active = 'active';
    case PastDue = 'past_due';
    case Suspended = 'suspended';
    case Expired = 'expired';
}
