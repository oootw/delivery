<?php

declare(strict_types=1);

namespace App\Application\Promotion\Entity\Promotion;

/**
 * Факт применения акции к заказу. Нужен для лимитов (общий и на гостя),
 * аудита и отката скидки при отмене заказа.
 */
class PromotionRedemption
{
    public function __construct(
        public ?int $id,
        public int $promotionId,
        public int $workspaceId,
        public int $orderId,
        public int $customerId,
        public int $discountKopecks,
        public \DateTimeImmutable $createdAt,
    ) {}

    public static function buildNew(
        int $promotionId,
        int $workspaceId,
        int $orderId,
        int $customerId,
        int $discountKopecks,
    ): self {
        return new self(
            id: null,
            promotionId: $promotionId,
            workspaceId: $workspaceId,
            orderId: $orderId,
            customerId: $customerId,
            discountKopecks: $discountKopecks,
            createdAt: new \DateTimeImmutable(),
        );
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }
}
