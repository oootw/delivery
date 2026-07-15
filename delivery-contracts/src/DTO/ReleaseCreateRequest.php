<?php

declare(strict_types=1);

namespace Delivery\Contracts\DTO;

final class ReleaseCreateRequest
{
    public function __construct(
        public readonly string $ref,
        public readonly string $contractVersion,
    ) {}
}

