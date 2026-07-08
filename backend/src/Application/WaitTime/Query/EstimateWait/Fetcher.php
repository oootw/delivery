<?php

declare(strict_types=1);

namespace App\Application\WaitTime\Query\EstimateWait;

use App\Application\Order\Entity\Order\OrderRepositoryInterface;
use App\Application\Order\Entity\Order\OrderStatusEnum;
use App\Application\Order\Entity\Order\OrderTypeEnum;
use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\WaitTime\Entity\KitchenProfile\KitchenProfile;
use App\Application\WaitTime\Entity\KitchenProfile\KitchenProfileRepositoryInterface;
use App\Application\WaitTime\Service\KitchenHistory;
use App\Application\WaitTime\Service\WaitTimeEstimator;
use App\Application\WaitTime\Service\WaitTimeInputs;

/**
 * Предварительная оценка времени ожидания до оформления заказа: гость видит,
 * сколько ждать, ещё в корзине. Считаем как для нового заказа (status=created)
 * с текущей нагрузкой кухни точки.
 */
class Fetcher
{
    private const KITCHEN_STATUSES = [OrderStatusEnum::Accepted, OrderStatusEnum::Cooking];

    public function __construct(
        private readonly VenueRepositoryInterface $venues,
        private readonly OrderRepositoryInterface $orders,
        private readonly KitchenProfileRepositoryInterface $kitchenProfiles,
        private readonly WaitTimeEstimator $estimator,
        private readonly KitchenHistory $kitchenHistory,
    ) {}

    public function fetch(Query $query): int
    {
        $venue = $this->venues->findById($query->venueId);

        if ($venue === null) {
            throw new \DomainException('Точка не найдена');
        }

        $type = OrderTypeEnum::tryFrom($query->type);

        if ($type === null) {
            throw new \DomainException('Неизвестный тип заказа');
        }

        if ($query->units < 1) {
            throw new \DomainException('Добавьте хотя бы одну позицию');
        }

        $profile = $this->kitchenProfiles->findByVenue($query->venueId)
            ?? KitchenProfile::buildDefault($query->venueId);

        return $this->estimator->estimateWaitMinutes(
            new WaitTimeInputs(
                status: OrderStatusEnum::Created,
                type: $type,
                units: $query->units,
                profile: $profile,
                queueAhead: $this->countKitchenQueue($query->venueId),
                elapsedCookingMinutes: null,
                historicalPerUnitMinutes: $this->kitchenHistory->averagePerUnitMinutes($query->venueId),
            ),
        );
    }

    private function countKitchenQueue(int $venueId): int
    {
        $inKitchen = 0;

        foreach ($this->orders->findInProgressByVenue($venueId) as $order) {
            if (in_array($order->status, self::KITCHEN_STATUSES, true)) {
                $inKitchen++;
            }
        }

        return $inKitchen;
    }
}
