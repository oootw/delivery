<?php

declare(strict_types=1);

namespace App\Application\Subscription\Entity\OwnerSubscription;

use Delivery\Contracts\Enum\TarifCodeEnum;

final class OwnerSubscription
{
    private function __construct(
        public ?int $id,
        public readonly int $ownerId,
        public TarifCodeEnum $tarifCode,
        public OwnerSubscriptionStatusEnum $status,
        public ?\DateTimeImmutable $validUntil,
    ) {}

    public static function buildNew(
        int $ownerId,
        TarifCodeEnum $tarifCode,
        OwnerSubscriptionStatusEnum $status,
        ?\DateTimeImmutable $validUntil,
    ): self {
        return new self(
            id: null,
            ownerId: $ownerId,
            tarifCode: $tarifCode,
            status: $status,
            validUntil: $validUntil,
        );
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }
}

