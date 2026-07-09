<?php

declare(strict_types=1);

namespace App\Application\Promotion\Service;

use App\Application\Promotion\Entity\Promotion\AppliedPromotion;
use App\Application\Promotion\Entity\Promotion\Promotion;
use App\Application\Promotion\Entity\Promotion\PromotionContext;
use App\Application\Promotion\Entity\Promotion\PromotionResult;

/**
 * Чистый движок применения скидок. Кандидаты (акции, уже прошедшие проверку условий
 * и лимитов) подаёт вызывающий адаптер.
 *
 * Правило стекинга (согласовано 2026-07-09) — управляется приоритетом и флагом stackable:
 * идём по акциям в порядке убывания приоритета; stackable-скидки суммируются; первая
 * встреченная не-stackable акция применяется только если до неё ничего не применилось
 * (эксклюзивная), и на ней применение останавливается. Так владелец полностью управляет
 * поведением через приоритет: эксклюзивную акцию ставят выше, чтобы она вытеснила прочие.
 *
 * Суммарная скидка ограничена так, чтобы к оплате оставалось не меньше MIN_PAYABLE_KOPECKS
 * (100%-скидку не допускаем — онлайн-оплата нулевой суммы невозможна).
 */
class PromotionEngine
{
    private const MIN_PAYABLE_KOPECKS = 100;

    /**
     * @param Promotion[] $candidates
     */
    public function apply(array $candidates, PromotionContext $context): PromotionResult
    {
        $subtotal = $context->subtotalKopecks;

        usort($candidates, function (Promotion $left, Promotion $right) use ($context): int {
            return $right->priority <=> $left->priority
                ?: $right->discountFor($context) <=> $left->discountFor($context);
        });

        $remaining = max(0, $subtotal - self::MIN_PAYABLE_KOPECKS);
        $applied = [];
        $total = 0;

        foreach ($candidates as $promotion) {
            if ($remaining <= 0) {
                break;
            }

            $discount = min($promotion->discountFor($context), $remaining);

            if ($discount <= 0) {
                continue;
            }

            if ($promotion->stackable) {
                $applied[] = new AppliedPromotion($promotion->id, $promotion->name, $discount);
                $total += $discount;
                $remaining -= $discount;

                continue;
            }

            // Не-stackable акция эксклюзивна: применяется только первой и завершает подбор.
            if ($applied === []) {
                $applied[] = new AppliedPromotion($promotion->id, $promotion->name, $discount);
                $total += $discount;
            }

            break;
        }

        return new PromotionResult($total, $applied);
    }
}
