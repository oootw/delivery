<?php

declare(strict_types=1);

namespace Delivery\Contracts\DTO;

final class RegisterRequest
{
    public function __construct(
        public readonly string $ownerSlug,
        public readonly string $domain,
        public readonly string $coreRef,
        public readonly string $contractVersion,
    ) {}
}

