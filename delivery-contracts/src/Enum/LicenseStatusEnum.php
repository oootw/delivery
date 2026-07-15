<?php

declare(strict_types=1);

namespace Delivery\Contracts\Enum;

enum LicenseStatusEnum: string
{
    case ACTIVE = 'active';
    case PAST_DUE = 'past_due';
    case SUSPENDED = 'suspended';
    case EXPIRED = 'expired';
}

