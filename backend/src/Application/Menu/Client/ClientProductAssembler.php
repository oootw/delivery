<?php

declare(strict_types=1);

namespace App\Application\Menu\Client;

use App\Application\Menu\Entity\MenuItem\MenuItem;
use App\Application\Menu\Entity\MenuItemNutrition\MenuItemNutrition;
use App\Application\Menu\Image\MenuImageStorageInterface;
use App\Application\Menu\Nutrition\Nutrition;

/**
 * Сборка витринных данных товара для клиента: эффективное БЖУ (POS-база + ручной оверрайд)
 * и изображения (галерея, с фолбэком на POS-картинку). Общее для списка и деталки товара.
 */
final class ClientProductAssembler
{
    public function __construct(
        private readonly MenuImageStorageInterface $menuImages,
    ) {}

    /** Эффективное БЖУ: оверрайд владельца поверх базы из POS (пофилдово). */
    public function effectiveNutrition(MenuItem $item, ?MenuItemNutrition $override): Nutrition
    {
        $base = $item->posNutrition ?? Nutrition::empty();

        if ($override === null) {
            return $base;
        }

        return $base->merge($override->nutrition);
    }

    /**
     * Изображения товара по порядку: галерея владельца, а если её нет — POS-картинка.
     *
     * @return string[]
     */
    public function images(string $slug, MenuItem $item): array
    {
        $gallery = array_values($this->menuImages->findItemGallery($slug, (int) $item->id));

        if ($gallery !== []) {
            return $gallery;
        }

        return $item->imageUrl !== null ? [$item->imageUrl] : [];
    }

    /** Калории для карточки: на порцию, иначе на 100 г. */
    public function displayKcal(Nutrition $nutrition): ?int
    {
        return $nutrition->perPortion?->kcal ?? $nutrition->per100g?->kcal;
    }
}
