<?php

declare(strict_types=1);

namespace App\Application\Subscription\Command\CancelSubscription;

use App\Application\Billing\Gateway\PaymentGatewayInterface;
use App\Application\Subscription\Entity\Subscription\SubscriptionRepositoryInterface;

class Handler
{
    public function __construct(
        private readonly SubscriptionRepositoryInterface $subscriptions,
        private readonly PaymentGatewayInterface $paymentGateway,
    ) {}

    public function handle(Command $command): void
    {
        $subscription = $this->subscriptions->findActiveByUser($command->userId);

        if ($subscription === null) {
            throw new \DomainException('Активная подписка не найдена');
        }

        if ($subscription->externalId !== null) {
            $this->paymentGateway->cancelSubscription($subscription->externalId);
        }

        $subscription->cancel();

        $this->subscriptions->save($subscription);
    }
}
