<?php

declare(strict_types=1);

namespace App\Application\Order\Rewards;

/**
 * Запрос на списание баллов при оформлении заказа. maxBaseKopecks — сумма к оплате
 * после скидок (от неё считается лимит оплаты баллами).
 */
final class RedeemQuoteRequest
{
    public function __construct(
        public readonly int $workspaceId,
        public readonly int $customerId,
        public readonly int $pointsToSpend,
        public readonly int $maxBaseKopecks,
    ) {}
}
