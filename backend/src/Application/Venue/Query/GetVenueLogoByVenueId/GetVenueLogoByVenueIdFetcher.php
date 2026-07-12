<?php

declare(strict_types=1);

namespace App\Application\Venue\Query\GetVenueLogoByVenueId;

use App\Application\Venue\Entity\Venue\VenueRepositoryInterface;
use App\Application\Venue\Logo\VenueLogoStorageInterface;
use App\Application\Workspace\Entity\Workspace\WorkspaceRepositoryInterface;

/**
 * URL логотипа точки. Доступен любому авторизованному клиенту (как просмотр меню).
 * Если логотип не загружен — logo_url = null.
 */
class GetVenueLogoByVenueIdFetcher
{
    public function __construct(
        private readonly VenueRepositoryInterface $venues,
        private readonly WorkspaceRepositoryInterface $workspaces,
        private readonly VenueLogoStorageInterface $venueLogos,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function fetch(GetVenueLogoByVenueIdQuery $query): array
    {
        $venue = $this->venues->findById($query->venueId);

        if ($venue === null) {
            throw new \DomainException('Точка не найдена');
        }

        $workspace = $this->workspaces->findById($venue->workspaceId);

        if ($workspace === null) {
            throw new \DomainException('Воркспейс точки не найден');
        }

        return [
            'logo_url' => $this->venueLogos->findUrl($workspace->slug, $venue->id),
        ];
    }
}
