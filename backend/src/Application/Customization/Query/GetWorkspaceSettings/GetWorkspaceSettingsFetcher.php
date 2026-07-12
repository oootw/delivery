<?php

declare(strict_types=1);

namespace App\Application\Customization\Query\GetWorkspaceSettings;

use App\Application\Customization\Entity\WorkspaceSettings\WorkspaceSettingsRepositoryInterface;
use App\Application\Customization\Settings\SettingDefinition;
use App\Application\Customization\Settings\SettingsCatalog;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Настройки воркспейса для UI: каждая объявленная настройка с её текущим значением
 * (сохранённое, иначе значение по умолчанию). Доступно любому участнику воркспейса.
 */
class GetWorkspaceSettingsFetcher
{
    public function __construct(
        private readonly SettingsCatalog $catalog,
        private readonly WorkspaceSettingsRepositoryInterface $settings,
        private readonly WorkspaceAccess $workspaceAccess,
    ) {}

    /**
     * @return list<array<string, mixed>>
     */
    public function fetch(GetWorkspaceSettingsQuery $query): array
    {
        $this->workspaceAccess->requireMember($query->workspaceId, $query->userId);

        $stored = $this->settings->findByWorkspace($query->workspaceId);

        return array_map(
            fn(SettingDefinition $definition): array => [
                'key' => $definition->key,
                'type' => $definition->type->value,
                'label' => $definition->label,
                'description' => $definition->description,
                'default' => $definition->default,
                'value' => $definition->coerce($stored?->get($definition->key) ?? $definition->default),
            ],
            array_values($this->catalog->all()),
        );
    }
}
