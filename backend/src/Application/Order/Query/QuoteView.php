<?php

declare(strict_types=1);

namespace App\Application\Order\Query;

use App\Application\Order\Entity\Order\OrderItem;
use App\Application\Order\Pricing\OrderPriceBreakdown;

/**
 * Read-model предпросмотра цены. Отдаёт ту же разбивку, что и OrderView у заказа
 * (subtotal → скидки → баллы → итог), но без полей уже созданного заказа.
 */
final class QuoteView
{
    /**
     * @return array<string, mixed>
     */
    public static function fromBreakdown(OrderPriceBreakdown $breakdown): array
    {
        return [
            'subtotal_kopecks' => $breakdown->subtotalKopecks,
            'discount_kopecks' => $breakdown->discountKopecks,
            'applied_discounts' => $breakdown->appliedDiscounts,
            'points_spent' => $breakdown->pointsSpent,
            'points_discount_kopecks' => $breakdown->pointsDiscountKopecks,
            'total_kopecks' => $breakdown->payableKopecks,
            'items' => array_map(
                static fn(OrderItem $item): array => $item->toArray() + ['line_total_kopecks' => $item->lineTotalKopecks()],
                $breakdown->orderItems,
            ),
        ];
    }
}
