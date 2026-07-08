<?php

declare(strict_types=1);

namespace App\Application\Subscription\Command\StopSubscription;

use App\Application\Subscription\Entity\Subscription\SubscriptionRepositoryInterface;

class Handler
{
    public function __construct(
        private readonly SubscriptionRepositoryInterface $subscriptions,
    ) {}

    public function handle(Command $command): void
    {
        $subscription = $this->subscriptions->findByExternalId($command->externalId);

        if ($subscription === null) {
            throw new \DomainException('Подписка для отмены не найдена');
        }

        $subscription->cancel();

        $this->subscriptions->save($subscription);
    }
}
