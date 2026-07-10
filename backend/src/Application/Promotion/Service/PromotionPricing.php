<?php

declare(strict_types=1);

namespace App\Application\Promotion\Service;

use App\Application\Order\Pricing\AppliedDiscount;
use App\Application\Order\Pricing\OrderPricingInterface;
use App\Application\Order\Pricing\OrderPricingRequest;
use App\Application\Order\Pricing\OrderPricingResult;
use App\Application\Order\Pricing\PricingLine;
use App\Application\Promotion\Entity\Promotion\AppliedPromotion;
use App\Application\Promotion\Entity\Promotion\CartLine;
use App\Application\Promotion\Entity\Promotion\Promotion;
use App\Application\Promotion\Entity\Promotion\PromotionContext;
use App\Application\Promotion\Entity\Promotion\PromotionRedemption;
use App\Application\Promotion\Entity\Promotion\PromotionRepositoryInterface;

/**
 * Адаптер расчёта скидок для заказа (реализует порт домена Order). Собирает
 * применимые акции, проверяет промокод и лимиты, отдаёт расчёт движку и
 * фиксирует/откатывает применения в леджере.
 */
class PromotionPricing implements OrderPricingInterface
{
    /** Итог к оплате не может опуститься ниже этого порога (см. PromotionEngine). */
    private const MIN_PAYABLE_KOPECKS = 100;

    /** Виртуальная скидка уровня не попадает в леджер применений (promotion_id ≤ 0). */
    private const TIER_PROMOTION_ID = 0;

    public function __construct(
        private readonly PromotionRepositoryInterface $promotions,
        private readonly PromotionEngine $engine,
    ) {}

    public function priceOrder(OrderPricingRequest $request): OrderPricingResult
    {
        $context = new PromotionContext(
            customerId: $request->customerId,
            orderType: $request->orderType,
            subtotalKopecks: $request->subtotalKopecks,
            now: $request->now,
            timezone: $request->timezone,
            isFirstOrder: $request->isFirstOrder,
            lines: array_map(
                static fn(PricingLine $line): CartLine => new CartLine(
                    menuItemExternalId: $line->menuItemExternalId,
                    categoryExternalId: $line->categoryExternalId,
                    lineTotalKopecks: $line->lineTotalKopecks,
                ),
                $request->lines,
            ),
        );

        $candidates = [];

        foreach ($this->promotions->findActiveAutomaticByVenue($request->workspaceId, $request->venueId) as $automatic) {
            if ($this->isAvailableForCustomer($automatic, $request->customerId) && $automatic->conditions->isSatisfiedBy($context)) {
                $candidates[] = $automatic;
            }
        }

        if ($request->promocode !== null && trim($request->promocode) !== '') {
            $candidates[] = $this->resolvePromocode($request, $context);
        }

        $result = $this->engine->apply($candidates, $context);

        $appliedDiscounts = array_map(
            static fn(AppliedPromotion $applied): AppliedDiscount => new AppliedDiscount(
                promotionId: $applied->promotionId,
                name: $applied->name,
                discountKopecks: $applied->discountKopecks,
            ),
            $result->applied,
        );

        // Постоянная скидка уровня складывается поверх акций (после промо, от остатка).
        $totalDiscount = $result->totalDiscountKopecks;
        $tierDiscount = $this->tierDiscountKopecks($request, $totalDiscount);

        if ($tierDiscount > 0) {
            $appliedDiscounts[] = new AppliedDiscount(
                promotionId: self::TIER_PROMOTION_ID,
                name: $request->tierName ?? 'Уровень лояльности',
                discountKopecks: $tierDiscount,
            );
            $totalDiscount += $tierDiscount;
        }

        return new OrderPricingResult(
            discountKopecks: $totalDiscount,
            appliedDiscounts: $appliedDiscounts,
        );
    }

    /** Скидка уровня от суммы после промо, ограниченная порогом минимального платежа. */
    private function tierDiscountKopecks(OrderPricingRequest $request, int $promoDiscount): int
    {
        if ($request->tierDiscountBasisPoints <= 0) {
            return 0;
        }

        $afterPromo = max(0, $request->subtotalKopecks - $promoDiscount);
        $raw = intdiv($afterPromo * $request->tierDiscountBasisPoints, 10000);
        $cap = max(0, $afterPromo - self::MIN_PAYABLE_KOPECKS);

        return min($raw, $cap);
    }

    public function recordApplied(int $orderId, OrderPricingRequest $request, OrderPricingResult $result): void
    {
        foreach ($result->appliedDiscounts as $applied) {
            // Виртуальная скидка уровня — не акция, в леджер применений не пишется.
            if ($applied->promotionId <= self::TIER_PROMOTION_ID) {
                continue;
            }

            $this->promotions->saveRedemption(
                PromotionRedemption::buildNew(
                    promotionId: $applied->promotionId,
                    workspaceId: $request->workspaceId,
                    orderId: $orderId,
                    customerId: $request->customerId,
                    discountKopecks: $applied->discountKopecks,
                ),
            );

            $promotion = $this->promotions->findById($applied->promotionId);

            if ($promotion !== null) {
                $promotion->registerRedemption();
                $this->promotions->save($promotion);
            }
        }
    }

    public function revertApplied(int $orderId): void
    {
        $redemptions = $this->promotions->findRedemptionsByOrder($orderId);

        if ($redemptions === []) {
            return;
        }

        foreach ($redemptions as $redemption) {
            $promotion = $this->promotions->findById($redemption->promotionId);

            if ($promotion !== null) {
                $promotion->revertRedemption();
                $this->promotions->save($promotion);
            }
        }

        $this->promotions->deleteRedemptionsByOrder($orderId);
    }

    private function resolvePromocode(OrderPricingRequest $request, PromotionContext $context): Promotion
    {
        $code = Promotion::normalizeCode($request->promocode ?? '');
        $promotion = $this->promotions->findActivePromocode($request->workspaceId, $code);

        if ($promotion === null) {
            throw new \DomainException('Промокод недействителен');
        }

        if ($promotion->venueId !== null && $promotion->venueId !== $request->venueId) {
            throw new \DomainException('Промокод не действует в этой точке');
        }

        if (!$this->isAvailableForCustomer($promotion, $request->customerId)) {
            throw new \DomainException('Промокод больше недоступен');
        }

        if (!$promotion->conditions->isSatisfiedBy($context)) {
            throw new \DomainException('Условия промокода не выполнены');
        }

        return $promotion;
    }

    private function isAvailableForCustomer(Promotion $promotion, int $customerId): bool
    {
        if ($promotion->isExhausted()) {
            return false;
        }

        if ($promotion->maxRedemptionsPerCustomer === null) {
            return true;
        }

        return $this->promotions->countRedemptionsByCustomer($promotion->id, $customerId)
            < $promotion->maxRedemptionsPerCustomer;
    }
}
