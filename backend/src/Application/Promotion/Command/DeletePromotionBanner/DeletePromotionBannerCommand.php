<?php

declare(strict_types=1);

namespace App\Application\Promotion\Command\DeletePromotionBanner;

class DeletePromotionBannerCommand
{
    public function __construct(
        public readonly int $userId,
        public readonly int $promotionId,
    ) {}
}
