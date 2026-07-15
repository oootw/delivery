<?php

declare(strict_types=1);

namespace Delivery\Contracts\DTO;

use Delivery\Contracts\Enum\FeatureCodeEnum;
use Delivery\Contracts\Enum\LicenseStatusEnum;
use Delivery\Contracts\Enum\TarifCodeEnum;

final class LicenseResponse
{
    /**
     * @param list<FeatureCodeEnum> $features
     */
    public function __construct(
        public readonly TarifCodeEnum $tarif,
        public readonly array $features,
        public readonly LicenseStatusEnum $status,
        public readonly ?\DateTimeImmutable $validUntil,
    ) {}
}

