<?php

declare(strict_types=1);

namespace App\Shared\Traits\InfoTrait;

class HelpInfo
{
    public function __construct(
        private readonly \DateTimeImmutable $createdAt,
    ) {}

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
