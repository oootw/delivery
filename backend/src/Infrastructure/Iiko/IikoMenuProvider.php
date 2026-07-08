<?php

declare(strict_types=1);

namespace App\Infrastructure\Iiko;

use App\Application\PosIntegration\Entity\PosConnection\PosConnection;
use App\Application\PosIntegration\Entity\PosConnection\PosSystemEnum;
use App\Application\PosIntegration\Gateway\PosCategory;
use App\Application\PosIntegration\Gateway\PosItem;
use App\Application\PosIntegration\Gateway\PosMenuProviderInterface;
use App\Application\PosIntegration\Gateway\PosMenuSnapshot;
use App\Application\PosIntegration\Gateway\PosModifier;
use App\Application\PosIntegration\Gateway\PosModifierGroup;
use GuzzleHttp\Client;
use IIKO\Api\AuthorizationApi;
use IIKO\Api\MenuApi;
use IIKO\ApiException;
use IIKO\Configuration;
use IIKO\Model\ExternalMenuCategory;
use IIKO\Model\ExternalMenuItem;
use IIKO\Model\ExternalMenuModifierGroup;
use IIKO\Model\IikoTransportPublicApiContractsAuthGetAccessTokenRequest;
use IIKO\Model\IikoTransportPublicApiContractsNomenclatureMenuRequest;

/**
 * Провайдер меню iiko через сгенерированный клиент IIKO\.
 * Поток: получить токен по apiLogin → запросить внешнее меню → нормализовать в снапшот.
 *
 * ВНИМАНИЕ: маппинг составлен по схеме клиента и требует проверки на реальном
 * ответе iiko (цены/модификаторы приходят внутри размеров позиции).
 */
final class IikoMenuProvider implements PosMenuProviderInterface
{
    private const REQUEST_TIMEOUT = 15;

    public function __construct(
        private readonly string $apiUrl,
    ) {}

    public function supports(PosSystemEnum $posSystem): bool
    {
        return $posSystem === PosSystemEnum::Iiko;
    }

    public function fetchMenu(PosConnection $connection): PosMenuSnapshot
    {
        $configuration = Configuration::getDefaultConfiguration()->setHost($this->apiUrl);
        $client = new Client();

        $authorizationApi = new AuthorizationApi($client, $configuration);
        $menuApi = new MenuApi($client, $configuration);

        try {
            $tokenResponse = $authorizationApi->api1AccessTokenPost(
                self::REQUEST_TIMEOUT,
                (new IikoTransportPublicApiContractsAuthGetAccessTokenRequest())->setApiLogin($connection->apiLogin),
            );

            $token = $tokenResponse->getToken();

            if ($token === null || $token === '') {
                throw new \DomainException('iiko не вернул токен доступа');
            }

            $menuResponse = $menuApi->api2MenuByIdPost(
                'Bearer ' . $token,
                self::REQUEST_TIMEOUT,
                (new IikoTransportPublicApiContractsNomenclatureMenuRequest())
                    ->setExternalMenuId($connection->externalMenuId)
                    ->setOrganizationIds([$connection->organizationId]),
            );
        } catch (ApiException $exception) {
            throw new \DomainException('Ошибка обращения к iiko: ' . $exception->getMessage());
        }

        return $this->mapSnapshot($menuResponse->getItemCategories() ?? []);
    }

    /**
     * @param ExternalMenuCategory[] $iikoCategories
     */
    private function mapSnapshot(array $iikoCategories): PosMenuSnapshot
    {
        $categories = [];
        $modifierGroups = [];
        $categoryPosition = 0;

        foreach ($iikoCategories as $iikoCategory) {
            $categoryExternalId = (string) $iikoCategory->getId();
            $items = [];
            $itemPosition = 0;

            foreach ($iikoCategory->getItems() ?? [] as $iikoItem) {
                $items[] = $this->mapItem($iikoItem, $categoryExternalId, $itemPosition, $modifierGroups);
                $itemPosition++;
            }

            $categories[] = new PosCategory(
                externalId: $categoryExternalId,
                name: (string) $iikoCategory->getName(),
                position: $categoryPosition,
                items: $items,
            );
            $categoryPosition++;
        }

        return new PosMenuSnapshot(
            categories: $categories,
            modifierGroups: array_values($modifierGroups),
        );
    }

    /**
     * @param array<string, PosModifierGroup> $modifierGroups собираются по ссылке между позициями
     */
    private function mapItem(
        ExternalMenuItem $iikoItem,
        string $categoryExternalId,
        int $position,
        array &$modifierGroups,
    ): PosItem {
        $sizes = $iikoItem->getItemSizes() ?? [];
        $firstSize = $sizes[0] ?? null;

        $modifierGroupExternalIds = [];

        if ($firstSize !== null) {
            foreach ($firstSize->getItemModifierGroups() ?? [] as $iikoGroup) {
                $group = $this->mapModifierGroup($iikoGroup);
                $modifierGroups[$group->externalId] = $group;
                $modifierGroupExternalIds[] = $group->externalId;
            }
        }

        $prices = $firstSize?->getPrices() ?? [];
        $priceRubles = $prices[0]?->getPrice() ?? 0.0;

        return new PosItem(
            externalId: (string) $iikoItem->getItemId(),
            categoryExternalId: $categoryExternalId,
            name: (string) $iikoItem->getName(),
            description: (string) $iikoItem->getDescription(),
            priceKopecks: (int) round($priceRubles * 100),
            imageUrl: $firstSize?->getButtonImageUrl(),
            isAvailable: $iikoItem->getIsHidden() !== true,
            position: $position,
            modifierGroupExternalIds: $modifierGroupExternalIds,
        );
    }

    private function mapModifierGroup(ExternalMenuModifierGroup $iikoGroup): PosModifierGroup
    {
        $restrictions = $iikoGroup->getRestrictions();

        $modifiers = array_map(
            fn($iikoModifier): PosModifier => new PosModifier(
                externalId: (string) $iikoModifier->getItemId(),
                name: (string) $iikoModifier->getName(),
                priceKopecks: (int) round(($iikoModifier->getPrices()[0]?->getPrice() ?? 0.0) * 100),
            ),
            $iikoGroup->getItems() ?? [],
        );

        return new PosModifierGroup(
            externalId: (string) $iikoGroup->getItemGroupId(),
            name: (string) $iikoGroup->getName(),
            minSelection: (int) ($restrictions?->getMinQuantity() ?? 0),
            maxSelection: (int) ($restrictions?->getMaxQuantity() ?? 0),
            modifiers: $modifiers,
        );
    }
}
