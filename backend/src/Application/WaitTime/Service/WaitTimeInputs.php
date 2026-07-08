<?php

declare(strict_types=1);

namespace App\Application\WaitTime\Service;

use App\Application\Order\Entity\Order\OrderStatusEnum;
use App\Application\Order\Entity\Order\OrderTypeEnum;
use App\Application\WaitTime\Entity\KitchenProfile\KitchenProfile;

/**
 * Согласованный набор входов для формулы времени ожидания. Собирается
 * пересчётчиком (WaitTimeRecalculator) и передаётся в чистый WaitTimeEstimator.
 */
final class WaitTimeInputs
{
    public function __construct(
        public readonly OrderStatusEnum $status,
        public readonly OrderTypeEnum $type,
        /** Единиц блюд в заказе (сумма количеств позиций) — трудоёмкость. */
        public readonly int $units,
        public readonly KitchenProfile $profile,
        /** Сколько заказов уже в работе на кухне впереди этого. */
        public readonly int $queueAhead,
        /** Минут прошло с начала готовки (если заказ уже cooking), иначе null. */
        public readonly ?int $elapsedCookingMinutes,
        /** Фактическое среднее время на единицу по точке, если данных достаточно. */
        public readonly ?float $historicalPerUnitMinutes,
    ) {}
}
