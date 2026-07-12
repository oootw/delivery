<?php

declare(strict_types=1);

namespace App\Application\Venue\Command\UploadVenueLogo;

use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Venue\Logo\VenueLogoStorageInterface;
use App\Application\Workspace\Service\WorkspaceAccess;

/**
 * Сохраняет логотип точки. Загружать может только владелец воркспейса; файл
 * кладётся в каталог воркспейса (по его slug) и заменяет прежний логотип точки.
 */
class UploadVenueLogoHandler
{
    public function __construct(
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceAccess $workspaceAccess,
        private readonly VenueLogoStorageInterface $venueLogos,
    ) {}

    public function handle(UploadVenueLogoCommand $command): string
    {
        $venue = $this->venues->findById($command->venueId);

        if ($venue === null) {
            throw new \DomainException('Точка не найдена');
        }

        $workspace = $this->workspaceAccess->getOwnedWorkspace(
            workspaceId: $venue->workspaceId,
            userId: $command->userId,
        );

        return $this->venueLogos->store(
            slug: $workspace->slug,
            venueId: $venue->id,
            sourcePath: $command->sourcePath,
            extension: $command->extension,
        );
    }
}
