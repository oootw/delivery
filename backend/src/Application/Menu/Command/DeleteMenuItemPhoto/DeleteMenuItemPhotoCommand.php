<?php

declare(strict_types=1);

namespace App\Application\Menu\Command\DeleteMenuItemPhoto;

class DeleteMenuItemPhotoCommand
{
    public function __construct(
        public readonly int $userId,
        public readonly int $venueId,
        public readonly int $itemId,
        public readonly int $index,
    ) {}
}
