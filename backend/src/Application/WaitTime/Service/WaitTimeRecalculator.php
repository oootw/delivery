<?php

declare(strict_types=1);

namespace App\Application\WaitTime\Service;

use App\Application\Order\Entity\Order\Order;
use App\Application\Order\Entity\Order\OrderRepositoryInterface;
use App\Application\Order\Entity\Order\OrderStatusEnum;
use App\Application\Order\Realtime\OrderRealtimeNotifierInterface;
use App\Application\Order\WaitTime\WaitTimeRecalculatorInterface;
use App\Application\WaitTime\Entity\KitchenProfile\KitchenProfile;
use App\Application\WaitTime\Entity\KitchenProfile\KitchenProfileRepositoryInterface;

/**
 * Пересчитывает время ожидания для всех активных заказов точки и рассылает
 * обновления гостям. Вызывается при изменении нагрузки (новый оплаченный заказ,
 * смена статуса, отмена) и по таймеру (консольная команда).
 *
 * Очередь считается по заказам, уже принятым в работу (accepted/cooking):
 * заказ ждёт тех, кто встал в работу раньше него.
 */
final class WaitTimeRecalculator implements WaitTimeRecalculatorInterface
{
    private const KITCHEN_STATUSES = [OrderStatusEnum::Accepted, OrderStatusEnum::Cooking];

    public function __construct(
        private readonly OrderRepositoryInterface $orders,
        private readonly KitchenProfileRepositoryInterface $kitchenProfiles,
        private readonly WaitTimeEstimator $estimator,
        private readonly KitchenHistory $kitchenHistory,
        private readonly OrderRealtimeNotifierInterface $realtimeNotifier,
    ) {}

    public function recalculateForVenue(int $venueId): void
    {
        $activeOrders = $this->orders->findInProgressByVenue($venueId);

        if ($activeOrders === []) {
            return;
        }

        $profile = $this->kitchenProfiles->findByVenue($venueId) ?? KitchenProfile::buildDefault($venueId);
        $historicalPerUnit = $this->kitchenHistory->averagePerUnitMinutes($venueId);

        foreach ($activeOrders as $order) {
            $minutes = $this->estimator->estimateWaitMinutes(
                new WaitTimeInputs(
                    status: $order->status,
                    type: $order->type,
                    units: $order->unitCount(),
                    profile: $profile,
                    queueAhead: $this->countQueueAhead($order, $activeOrders),
                    elapsedCookingMinutes: $this->elapsedCookingMinutes($order),
                    historicalPerUnitMinutes: $historicalPerUnit,
                ),
            );

            $order->applyWaitEstimate($minutes);
            $this->orders->save($order);
            $this->realtimeNotifier->publishStatus($order);
        }
    }

    /**
     * @param Order[] $activeOrders
     */
    private function countQueueAhead(Order $order, array $activeOrders): int
    {
        $ahead = 0;

        foreach ($activeOrders as $other) {
            if ($other->id === $order->id) {
                continue;
            }

            $isInKitchen = in_array($other->status, self::KITCHEN_STATUSES, true);

            if ($isInKitchen && $other->createdAt < $order->createdAt) {
                $ahead++;
            }
        }

        return $ahead;
    }

    private function elapsedCookingMinutes(Order $order): ?int
    {
        if ($order->status !== OrderStatusEnum::Cooking) {
            return null;
        }

        $startedAt = $order->enteredStatusAt(OrderStatusEnum::Cooking);

        if ($startedAt === null) {
            return null;
        }

        $elapsed = (new \DateTimeImmutable())->getTimestamp() - $startedAt->getTimestamp();

        return (int) max(0, intdiv($elapsed, 60));
    }
}
