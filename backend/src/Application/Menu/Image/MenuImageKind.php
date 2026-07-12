<?php

declare(strict_types=1);

namespace App\Application\Menu\Image;

/**
 * Вид сущности меню, к которой относится загруженное фото. Значение используется
 * в URL эндпоинта загрузки и как часть имени файла в хранилище.
 */
enum MenuImageKind: string
{
    case Category = 'category';
    case Item = 'item';
    case ModifierGroup = 'modifier-group';
    case Modifier = 'modifier';
    case Combo = 'combo';

    /** Префикс имени файла в каталоге воркспейса: menu-{kind}-{id}.{ext}. */
    public function filePrefix(): string
    {
        return 'menu-' . $this->value;
    }
}
