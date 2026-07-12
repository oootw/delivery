<?php

declare(strict_types=1);

namespace App\Application\Promotion\Command\SetPromotionBanner;

class SetPromotionBannerCommand
{
    public function __construct(
        public readonly int $userId,
        public readonly int $promotionId,
        public readonly ?string $bannerTitle,
        public readonly ?string $bannerText,
    ) {}
}
