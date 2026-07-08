<?php

declare(strict_types=1);

namespace App\Application\Order\WaitTime;

/**
 * Порт пересчёта времени ожидания. Реализация — в домене WaitTime.
 *
 * Заказ ничего не знает про формулу: когда меняется нагрузка точки (новый
 * оплаченный заказ, смена статуса, отмена), обработчики заказа просят пересчитать
 * ETA для всех активных заказов точки через этот порт.
 */
interface WaitTimeRecalculatorInterface
{
    public function recalculateForVenue(int $venueId): void;
}
