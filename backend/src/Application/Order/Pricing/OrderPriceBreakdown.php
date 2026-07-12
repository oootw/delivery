<?php

declare(strict_types=1);

namespace App\Application\Order\Pricing;

use App\Application\Order\Entity\Order\OrderItem;
use App\Application\Order\Entity\Order\OrderTypeEnum;
use App\Application\Order\Rewards\RedeemQuoteRequest;
use App\Application\Order\Rewards\RedeemQuoteResult;

/**
 * Полная разбивка цены заказа, посчитанная сервером: позиции, скидки, баллы и итог
 * к оплате. Используется и при оформлении (PlaceOrder), и при предпросмотре (quote),
 * чтобы расчёт совпадал 1:1. Помимо витринных полей несёт запросы/результаты портов —
 * оформление применяет их как побочные эффекты (запись скидок и резерв баллов).
 */
final class OrderPriceBreakdown
{
    /**
     * @param OrderItem[] $orderItems
     * @param array<int, array{promotion_id: int, name: string, discount_kopecks: int}> $appliedDiscounts
     */
    public function __construct(
        public readonly int $workspaceId,
        public readonly int $venueId,
        public readonly OrderTypeEnum $type,
        public readonly array $orderItems,
        public readonly int $subtotalKopecks,
        public readonly int $discountKopecks,
        public readonly array $appliedDiscounts,
        public readonly int $pointsSpent,
        public readonly int $pointsDiscountKopecks,
        public readonly int $payableKopecks,
        public readonly OrderPricingRequest $pricingRequest,
        public readonly OrderPricingResult $pricingResult,
        public readonly RedeemQuoteRequest $redeemRequest,
        public readonly RedeemQuoteResult $redeemResult,
    ) {}
}
