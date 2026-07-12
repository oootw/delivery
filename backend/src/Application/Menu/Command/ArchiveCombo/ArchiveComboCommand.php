<?php

declare(strict_types=1);

namespace App\Application\Menu\Command\ArchiveCombo;

class ArchiveComboCommand
{
    public function __construct(
        public readonly int $userId,
        public readonly int $comboId,
    ) {}
}
