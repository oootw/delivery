<?php

declare(strict_types=1);

namespace App\Application\Menu\Query\GetClientBannersByVenueId;

use App\Application\Menu\Client\ClientMenuAccess;
use App\Application\Promotion\Banner\PromotionBannerStorageInterface;
use App\Application\Promotion\Entity\Promotion\Promotion;
use App\Application\Promotion\Entity\Promotion\PromotionRepositoryInterface;

/**
 * Витрина баннеров с акциями для клиента: активные автоматические акции точки,
 * у которых загружена баннерная картинка. Заголовок баннера — bannerTitle либо имя акции.
 */
class GetClientBannersByVenueIdFetcher
{
    public function __construct(
        private readonly ClientMenuAccess $access,
        private readonly PromotionRepositoryInterface $promotions,
        private readonly PromotionBannerStorageInterface $banners,
    ) {}

    /**
     * @return array<int, array<string, mixed>>
     */
    public function fetch(GetClientBannersByVenueIdQuery $query): array
    {
        $venue = $this->access->venueOfWorkspace($query->workspaceSlug, $query->venueId);

        $result = [];

        foreach ($this->promotions->findActiveAutomaticByVenue($venue->workspaceId, (int) $venue->id) as $promotion) {
            $imageUrl = $this->banners->findUrl($query->workspaceSlug, (int) $promotion->id);

            if ($imageUrl === null) {
                continue;
            }

            $result[] = [
                'id' => $promotion->id,
                'title' => $promotion->bannerTitle ?? $promotion->name,
                'text' => $promotion->bannerText,
                'image_url' => $imageUrl,
            ];
        }

        return $result;
    }
}
