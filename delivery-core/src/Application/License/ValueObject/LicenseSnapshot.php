<?php

declare(strict_types=1);

namespace App\Application\License\ValueObject;

use Delivery\Contracts\Enum\FeatureCodeEnum;
use Delivery\Contracts\Enum\LicenseStatusEnum;
use Delivery\Contracts\Enum\TarifCodeEnum;

final class LicenseSnapshot
{
    /**
     * @param list<FeatureCodeEnum> $features
     */
    public function __construct(
        public readonly TarifCodeEnum $tarifCode,
        public readonly array $features,
        public readonly LicenseStatusEnum $status,
        public readonly ?\DateTimeImmutable $validUntil,
        public readonly \DateTimeImmutable $fetchedAt,
    ) {}
}

