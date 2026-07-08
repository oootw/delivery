<?php

declare(strict_types=1);

namespace App\Application\WaitTime\Service;

use App\Application\Order\Entity\Order\Order;
use App\Application\Order\Entity\Order\OrderRepositoryInterface;
use App\Application\Order\Entity\Order\OrderStatusEnum;

/**
 * Историческая калибровка: среднее фактическое время готовки на единицу блюда
 * по недавним заказам точки (от статуса «paid» до «ready»). Пока фактических
 * данных мало — возвращает null, и формула опирается на настройки точки.
 */
final class KitchenHistory
{
    private const RECENT_ORDERS_LIMIT = 20;
    private const MIN_SAMPLES = 5;

    public function __construct(
        private readonly OrderRepositoryInterface $orders,
    ) {}

    public function averagePerUnitMinutes(int $venueId): ?float
    {
        $samples = [];

        foreach ($this->orders->findRecentReadyByVenue($venueId, self::RECENT_ORDERS_LIMIT) as $order) {
            $perUnit = $this->perUnitMinutes($order);

            if ($perUnit !== null) {
                $samples[] = $perUnit;
            }
        }

        if (count($samples) < self::MIN_SAMPLES) {
            return null;
        }

        return array_sum($samples) / count($samples);
    }

    private function perUnitMinutes(Order $order): ?float
    {
        $paidAt = $order->enteredStatusAt(OrderStatusEnum::Paid);
        $readyAt = $order->enteredStatusAt(OrderStatusEnum::Ready);
        $units = $order->unitCount();

        if ($paidAt === null || $readyAt === null || $units < 1) {
            return null;
        }

        $cookMinutes = ($readyAt->getTimestamp() - $paidAt->getTimestamp()) / 60;

        if ($cookMinutes <= 0) {
            return null;
        }

        return $cookMinutes / $units;
    }
}
