<?php

declare(strict_types=1);

namespace App\Application\Promotion\Command\CreatePromotion;

final class CreatedPromotionDTO
{
    public function __construct(
        public readonly int $id,
    ) {}
}
