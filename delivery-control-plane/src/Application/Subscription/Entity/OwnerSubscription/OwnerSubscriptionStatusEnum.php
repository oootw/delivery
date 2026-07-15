<?php

declare(strict_types=1);

namespace App\Application\Subscription\Entity\OwnerSubscription;

enum OwnerSubscriptionStatusEnum: string
{
    case ACTIVE = 'active';
    case PAST_DUE = 'past_due';
    case SUSPENDED = 'suspended';
    case EXPIRED = 'expired';
}

