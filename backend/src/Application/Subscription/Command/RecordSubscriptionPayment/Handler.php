<?php

declare(strict_types=1);

namespace App\Application\Subscription\Command\RecordSubscriptionPayment;

use App\Application\Subscription\Entity\Subscription\Subscription;
use App\Application\Subscription\Entity\Subscription\SubscriptionRepositoryInterface;

class Handler
{
    public function __construct(
        private readonly SubscriptionRepositoryInterface $subscriptions,
    ) {}

    public function handle(Command $command): void
    {
        $subscription = $this->findSubscription($command);

        if ($subscription === null) {
            throw new \DomainException('Подписка для платежа не найдена');
        }

        $subscription->registerPayment(
            externalId: $command->externalId,
            paidAt: $command->paidAt,
        );

        $this->subscriptions->save($subscription);
    }

    private function findSubscription(Command $command): ?Subscription
    {
        if ($command->externalId !== null) {
            $byExternalId = $this->subscriptions->findByExternalId($command->externalId);

            if ($byExternalId !== null) {
                return $byExternalId;
            }
        }

        if ($command->invoiceId !== null) {
            return $this->subscriptions->findByInvoiceId($command->invoiceId);
        }

        return null;
    }
}
