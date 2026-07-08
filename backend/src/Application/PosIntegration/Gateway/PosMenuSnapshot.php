<?php

declare(strict_types=1);

namespace App\Application\PosIntegration\Gateway;

/**
 * Нормализованный снимок меню из POS-системы.
 * Категории содержат позиции; группы модификаторов вынесены отдельно,
 * позиции ссылаются на них по externalId.
 */
final class PosMenuSnapshot
{
    /**
     * @param PosCategory[] $categories
     * @param PosModifierGroup[] $modifierGroups
     */
    public function __construct(
        public readonly array $categories,
        public readonly array $modifierGroups,
    ) {}
}
