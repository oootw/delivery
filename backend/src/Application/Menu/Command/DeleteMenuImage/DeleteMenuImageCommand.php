<?php

declare(strict_types=1);

namespace App\Application\Menu\Command\DeleteMenuImage;

use App\Application\Menu\Image\MenuImageKind;

class DeleteMenuImageCommand
{
    public function __construct(
        public readonly int $userId,
        public readonly int $venueId,
        public readonly MenuImageKind $kind,
        public readonly int $entityId,
    ) {}
}
