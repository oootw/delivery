<?php

declare(strict_types=1);

namespace App\Application\Promotion\Command\CreatePromotion;

class Command
{
    /**
     * @param list<string> $targetRefs
     * @param array<string, mixed> $conditions
     */
    public function __construct(
        public readonly int $ownerId,
        public readonly int $workspaceId,
        public readonly ?int $venueId,
        public readonly string $name,
        public readonly string $type,
        public readonly ?string $code,
        public readonly string $rewardType,
        public readonly int $rewardValue,
        public readonly string $target,
        public readonly array $targetRefs,
        public readonly int $priority,
        public readonly bool $stackable,
        public readonly ?int $maxRedemptions,
        public readonly ?int $maxRedemptionsPerCustomer,
        public readonly array $conditions,
    ) {}
}
