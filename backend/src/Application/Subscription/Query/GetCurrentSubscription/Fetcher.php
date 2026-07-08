<?php

declare(strict_types=1);

namespace App\Application\Subscription\Query\GetCurrentSubscription;

use App\Application\Subscription\Entity\Subscription\Subscription;
use App\Application\Subscription\Entity\Subscription\SubscriptionRepositoryInterface;

class Fetcher
{
    public function __construct(
        private readonly SubscriptionRepositoryInterface $subscriptions,
    ) {}

    public function fetch(Query $query): ?SubscriptionDTO
    {
        $subscription = $this->subscriptions->findActiveByUser($query->userId)
            ?? $this->subscriptions->findLatestByUser($query->userId);

        if ($subscription === null) {
            return null;
        }

        return $this->toDTO($subscription);
    }

    private function toDTO(Subscription $subscription): SubscriptionDTO
    {
        return new SubscriptionDTO(
            id: $subscription->id,
            tarifCode: $subscription->tarifCode->value,
            status: $subscription->status->value,
            isActive: $subscription->isActive(),
            currentPeriodEnd: $subscription->currentPeriodEnd?->format(\DateTimeInterface::ATOM),
        );
    }
}
