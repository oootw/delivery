<?php

declare(strict_types=1);

namespace App\Application\Workspace\Entity\Workspace;

use App\Shared\VO\Image\ImageValueObject;

class Workspace
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $slug,
        public readonly string $description,
        public readonly ImageValueObject $logo,

        public readonly int $ownerId,
        public readonly \DateTimeImmutable $createdAt,
        public readonly \DateTimeImmutable $updatedAt,
    ) {}
}
