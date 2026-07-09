<?php

declare(strict_types=1);

namespace App\Application\Promotion\Command\DeletePromotion;

class Command
{
    public function __construct(
        public readonly int $userId,
        public readonly int $promotionId,
    ) {}
}
