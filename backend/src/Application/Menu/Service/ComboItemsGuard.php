<?php

declare(strict_types=1);

namespace App\Application\Menu\Service;

use App\Application\Menu\Entity\Combo\ComboItem;
use App\Application\Menu\Entity\MenuItem\MenuItemRepositoryInterface;

/**
 * Проверяет, что все товары состава комбо существуют в актуальном меню точки
 * (не архивные). Общая проверка для создания и обновления комбо.
 */
final class ComboItemsGuard
{
    public function __construct(
        private readonly MenuItemRepositoryInterface $menuItems,
    ) {}

    /**
     * @param ComboItem[] $items
     */
    public function assertItemsExist(int $venueId, array $items): void
    {
        $known = [];

        foreach ($this->menuItems->findActiveByVenue($venueId) as $menuItem) {
            $known[$menuItem->externalId] = true;
        }

        foreach ($items as $item) {
            if (!isset($known[$item->itemExternalId])) {
                throw new \DomainException('Товар комбо не найден в меню: ' . $item->itemExternalId);
            }
        }
    }
}
