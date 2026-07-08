<?php

declare(strict_types=1);

namespace App\Application\Subscription\Entity\Subscription;

enum SubscriptionStatusEnum: string
{
    /** Подписка создана, но первый платёж ещё не прошёл. */
    case Pending = 'pending';

    /** Платёж прошёл, подписка действует. */
    case Active = 'active';

    /** Очередное списание не удалось. */
    case PastDue = 'past_due';

    /** Подписка отменена владельцем или платёжной системой. */
    case Canceled = 'canceled';
}
