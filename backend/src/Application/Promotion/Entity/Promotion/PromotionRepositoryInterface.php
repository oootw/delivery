<?php

declare(strict_types=1);

namespace App\Application\Promotion\Entity\Promotion;

interface PromotionRepositoryInterface
{
    public function save(Promotion $promotion): int;

    public function findById(int $id): ?Promotion;

    public function delete(Promotion $promotion): void;

    /**
     * Все акции воркспейса (для управления владельцем).
     *
     * @return Promotion[]
     */
    public function findAllByWorkspace(int $workspaceId): array;

    /**
     * Активные автоматические акции, применимые к точке (венью или всему воркспейсу).
     *
     * @return Promotion[]
     */
    public function findActiveAutomaticByVenue(int $workspaceId, int $venueId): array;

    /** Активная акция-промокод по нормализованному коду в рамках воркспейса. */
    public function findActivePromocode(int $workspaceId, string $code): ?Promotion;

    public function saveRedemption(PromotionRedemption $redemption): void;

    public function countRedemptionsByCustomer(int $promotionId, int $customerId): int;

    /**
     * @return PromotionRedemption[]
     */
    public function findRedemptionsByOrder(int $orderId): array;

    public function deleteRedemptionsByOrder(int $orderId): void;
}
