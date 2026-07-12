<?php

declare(strict_types=1);

namespace App\Application\Customization\Command\SetWorkspaceSettings;

class SetWorkspaceSettingsCommand
{
    /**
     * @param array<string, mixed> $values «сырые» значения из запроса (валидируются по каталогу)
     */
    public function __construct(
        public readonly int $ownerId,
        public readonly int $workspaceId,
        public readonly array $values,
    ) {}
}
