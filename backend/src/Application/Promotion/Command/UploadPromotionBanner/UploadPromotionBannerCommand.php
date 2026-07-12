<?php

declare(strict_types=1);

namespace App\Application\Promotion\Command\UploadPromotionBanner;

class UploadPromotionBannerCommand
{
    public function __construct(
        public readonly int $userId,
        public readonly int $promotionId,
        public readonly string $sourcePath,
        public readonly string $extension,
    ) {}
}
