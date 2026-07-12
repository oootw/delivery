<?php

declare(strict_types=1);

namespace App\Application\Menu\Image;

use App\Application\Menu\Entity\Category\CategoryRepositoryInterface;
use App\Application\Menu\Entity\Combo\ComboRepositoryInterface;
use App\Application\Menu\Entity\MenuItem\MenuItemRepositoryInterface;
use App\Application\Menu\Entity\Modifier\ModifierRepositoryInterface;
use App\Application\Menu\Entity\ModifierGroup\ModifierGroupRepositoryInterface;

/**
 * По виду и id сущности меню возвращает точку, к которой она относится. Нужен эндпоинтам
 * фотографий, чтобы проверить принадлежность сущности точке и права владельца.
 */
final class MenuImageEntityLocator
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categories,
        private readonly MenuItemRepositoryInterface $items,
        private readonly ModifierGroupRepositoryInterface $modifierGroups,
        private readonly ModifierRepositoryInterface $modifiers,
        private readonly ComboRepositoryInterface $combos,
    ) {}

    /** venueId сущности или null, если её нет. */
    public function venueIdOf(MenuImageKind $kind, int $id): ?int
    {
        $entity = match ($kind) {
            MenuImageKind::Category => $this->categories->findById($id),
            MenuImageKind::Item => $this->items->findById($id),
            MenuImageKind::ModifierGroup => $this->modifierGroups->findById($id),
            MenuImageKind::Modifier => $this->modifiers->findById($id),
            MenuImageKind::Combo => $this->combos->findById($id),
        };

        return $entity?->venueId;
    }
}
