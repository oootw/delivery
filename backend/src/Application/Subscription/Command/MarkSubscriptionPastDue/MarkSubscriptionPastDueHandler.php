<?php

declare(strict_types=1);

namespace App\Application\Subscription\Command\MarkSubscriptionPastDue;

use App\Application\Subscription\Entity\Subscription\SubscriptionRepositoryInterface;

class MarkSubscriptionPastDueHandler
{
    public function __construct(
        private readonly SubscriptionRepositoryInterface $subscriptions,
    ) {}

    public function handle(MarkSubscriptionPastDueCommand $command): void
    {
        $subscription = $this->subscriptions->findByExternalId($command->externalId);

        if ($subscription === null) {
            throw new \DomainException('Подписка для платежа не найдена');
        }

        $subscription->markPastDue();

        $this->subscriptions->save($subscription);
    }
}
