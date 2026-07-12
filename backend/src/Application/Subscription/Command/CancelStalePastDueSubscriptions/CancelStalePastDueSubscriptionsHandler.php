<?php

declare(strict_types=1);

namespace App\Application\Subscription\Command\CancelStalePastDueSubscriptions;

use App\Shared\Contract\Payment\PaymentGateway\PaymentGatewayInterface;
use App\Application\Subscription\Entity\Subscription\Subscription;
use App\Application\Subscription\Entity\Subscription\SubscriptionRepositoryInterface;
use App\Shared\Service\LoggerService\LoggerService;

/**
 * Отменяет подписки, провисевшие в past_due дольше grace-периода. Возвращает число отменённых.
 */
class CancelStalePastDueSubscriptionsHandler
{
    public function __construct(
        private readonly SubscriptionRepositoryInterface $subscriptions,
        private readonly PaymentGatewayInterface $paymentGateway,
    ) {}

    public function handle(CancelStalePastDueSubscriptionsCommand $command): int
    {
        $cutoff = (new \DateTimeImmutable())->modify(sprintf('-%d days', $command->graceDays));
        $stale = $this->subscriptions->findPastDueOlderThan($cutoff);

        foreach ($stale as $subscription) {
            $this->cancel($subscription);
        }

        return count($stale);
    }

    private function cancel(Subscription $subscription): void
    {
        // Останавливаем рекуррент на стороне CloudPayments, но сбой шлюза не должен
        // мешать локальной отмене (устойчивая итерация по многим подпискам).
        if ($subscription->externalId !== null) {
            try {
                $this->paymentGateway->cancelSubscription($subscription->externalId);
            } catch (\Throwable $exception) {
                LoggerService::toFile(
                    fileName: 'subscription/cancel-past-due',
                    message: $subscription->externalId . ': ' . $exception->getMessage(),
                );
            }
        }

        $subscription->cancel();
        $this->subscriptions->save($subscription);
    }
}
