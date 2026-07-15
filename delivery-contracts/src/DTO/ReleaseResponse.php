<?php

declare(strict_types=1);

namespace Delivery\Contracts\DTO;

final class ReleaseResponse
{
    public function __construct(
        public readonly string $ref,
        public readonly string $contractVersion,
        public readonly bool $latest,
    ) {}
}

