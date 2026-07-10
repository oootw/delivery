<?php

declare(strict_types=1);

namespace App\Application\Order\Rewards;

/**
 * Порт бонусной системы для заказа. Реализуется доменом Loyalty (по образцу
 * OrderPricingInterface), чтобы Order не зависел от лояльности напрямую.
 *
 * Списание баллов: quoteRedeem считает сумму без записи (для расчёта итога);
 * reserveOnPlace резервирует баллы под сохранённый заказ; finalizeOnPaid списывает
 * их при оплате; releaseOnCancel возвращает резерв (или начисленное обратно) при отмене.
 * accrueOnCompleted начисляет кэшбэк при завершении заказа и возвращает число баллов.
 */
interface OrderRewardsInterface
{
    public function quoteRedeem(RedeemQuoteRequest $request): RedeemQuoteResult;

    public function reserveOnPlace(int $orderId, RedeemQuoteRequest $request, RedeemQuoteResult $result): void;

    public function finalizeOnPaid(int $orderId): void;

    public function releaseOnCancel(int $orderId, int $workspaceId, int $customerId, int $netPaidKopecks): void;

    public function accrueOnCompleted(int $orderId, int $workspaceId, int $customerId, int $netPaidKopecks): int;

    public function currentTierDiscount(int $workspaceId, int $customerId): TierDiscount;
}
