<?php

declare(strict_types=1);

namespace App\Application\Promotion\Command\ChangePromotionActivity;

class ChangePromotionActivityCommand
{
    public function __construct(
        public readonly int $userId,
        public readonly int $promotionId,
        public readonly bool $isActive,
    ) {}
}
