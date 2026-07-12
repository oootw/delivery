<?php

declare(strict_types=1);

namespace App\Application\Promotion\Query\GetPromotionById;

class GetPromotionByIdQuery
{
    public function __construct(
        public readonly int $userId,
        public readonly int $promotionId,
    ) {}
}
