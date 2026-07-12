<?php

declare(strict_types=1);

namespace App\Application\Menu\Command\UploadMenuImage;

use App\Application\Menu\Image\MenuImageKind;

class UploadMenuImageCommand
{
    public function __construct(
        public readonly int $userId,
        public readonly int $venueId,
        public readonly MenuImageKind $kind,
        public readonly int $entityId,
        public readonly string $sourcePath,
        public readonly string $extension,
    ) {}
}
