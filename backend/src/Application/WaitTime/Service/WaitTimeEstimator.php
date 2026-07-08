<?php

declare(strict_types=1);

namespace App\Application\WaitTime\Service;

use App\Application\Order\Entity\Order\OrderStatusEnum;
use App\Application\Order\Entity\Order\OrderTypeEnum;

/**
 * Оценка времени ожидания заказа. Чистая функция от согласованных входов
 * (см. WaitTimeInputs) — легко тестируется и калибруется.
 *
 * Договорённость по формуле (2026-07-08):
 *  1. Своё время готовки заказа = base + perUnit × units,
 *     где perUnit — смесь настроенного и фактического исторического времени.
 *  2. Ожидание в очереди = (заказов впереди ÷ параллельная мощность) × своё время
 *     готовки — чем больше нагрузка кухни, тем дольше.
 *  3. Пока заказ ещё не готовится, ждём очередь + свою готовку целиком; в процессе
 *     готовки — только остаток; после готовности кухонное время равно нулю.
 *  4. Для доставки к кухонному времени прибавляется логистическое плечо
 *     (deliveryMinutes); для самовывоза плеча нет.
 *
 * Возвращает целое число минут «осталось ждать от текущего момента», не меньше нуля.
 */
final class WaitTimeEstimator
{
    /** Вес исторического факта при смешивании с настроенным временем на единицу. */
    private const HISTORY_WEIGHT = 0.5;

    public function estimateWaitMinutes(WaitTimeInputs $inputs): int
    {
        if ($inputs->status->isTerminal()) {
            return 0;
        }

        $perUnitMinutes = $this->blendPerUnitMinutes(
            configured: $inputs->profile->perUnitMinutes,
            historical: $inputs->historicalPerUnitMinutes,
        );

        $ownCookMinutes = $inputs->profile->baseMinutes + $perUnitMinutes * $inputs->units;

        $cookMinutesLeft = $this->cookMinutesLeft($inputs, $ownCookMinutes);
        $deliveryMinutesLeft = $this->deliveryMinutesLeft($inputs);

        return (int) ceil(max(0.0, $cookMinutesLeft + $deliveryMinutesLeft));
    }

    private function blendPerUnitMinutes(int $configured, ?float $historical): float
    {
        if ($historical === null) {
            return (float) $configured;
        }

        return self::HISTORY_WEIGHT * $historical + (1 - self::HISTORY_WEIGHT) * $configured;
    }

    private function cookMinutesLeft(WaitTimeInputs $inputs, float $ownCookMinutes): float
    {
        return match ($inputs->status) {
            OrderStatusEnum::Created,
            OrderStatusEnum::Paid,
            OrderStatusEnum::Accepted => $this->queueMinutes($inputs, $ownCookMinutes) + $ownCookMinutes,
            OrderStatusEnum::Cooking => max(0.0, $ownCookMinutes - (float) ($inputs->elapsedCookingMinutes ?? 0)),
            OrderStatusEnum::Ready,
            OrderStatusEnum::OnTheWay,
            OrderStatusEnum::Completed,
            OrderStatusEnum::Canceled => 0.0,
        };
    }

    private function queueMinutes(WaitTimeInputs $inputs, float $ownCookMinutes): float
    {
        $capacity = max(1, $inputs->profile->parallelCapacity);

        return ($inputs->queueAhead / $capacity) * $ownCookMinutes;
    }

    private function deliveryMinutesLeft(WaitTimeInputs $inputs): float
    {
        if ($inputs->type !== OrderTypeEnum::Delivery) {
            return 0.0;
        }

        // До завершения доставки держим полное плечо: точного положения курьера нет,
        // поэтому не уменьшаем его на статусе on_the_way (уточним, когда появится трекинг).
        return $inputs->status === OrderStatusEnum::Completed
            ? 0.0
            : (float) $inputs->profile->deliveryMinutes;
    }
}
