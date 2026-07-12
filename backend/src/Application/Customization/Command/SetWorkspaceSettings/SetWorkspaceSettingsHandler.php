<?php

declare(strict_types=1);

namespace App\Application\Customization\Command\SetWorkspaceSettings;

use App\Application\Customization\Entity\WorkspaceSettings\WorkspaceSettingsRepositoryInterface;
use App\Application\Customization\Settings\SettingsCatalog;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Сохранение настроек воркспейса владельцем. «Сырые» значения валидируются и приводятся к
 * объявленным типам по каталогу (неизвестный ключ/неверный тип → отказ), затем сливаются в
 * существующую карту (частичное обновление — не переданные ключи сохраняются).
 */
class SetWorkspaceSettingsHandler
{
    public function __construct(
        private readonly SettingsCatalog $catalog,
        private readonly WorkspaceSettingsRepositoryInterface $settings,
        private readonly WorkspaceAccess $workspaceAccess,
    ) {}

    public function handle(SetWorkspaceSettingsCommand $command): void
    {
        $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $command->workspaceId,
            userId: $command->ownerId,
        );

        $coerced = $this->catalog->coerce($command->values);

        $settings = $this->settings->getOrCreate($command->workspaceId);
        $settings->setMany($coerced);

        $this->settings->save($settings);
    }
}
