<?php

declare(strict_types=1);

namespace App\Application\Order\Pricing;

/**
 * Порт расчёта скидок для заказа. Реализуется доменом Promotion (по образцу
 * WaitTimeRecalculatorInterface), чтобы Order не зависел от промо-акций напрямую.
 *
 * priceOrder — считает и валидирует скидку (бросает при недействительном промокоде),
 * но ничего не пишет. recordApplied — фиксирует применение (леджер + счётчики лимитов)
 * после сохранения заказа. revertApplied — откатывает применение при отмене заказа.
 */
interface OrderPricingInterface
{
    public function priceOrder(OrderPricingRequest $request): OrderPricingResult;

    public function recordApplied(int $orderId, OrderPricingRequest $request, OrderPricingResult $result): void;

    public function revertApplied(int $orderId): void;
}
