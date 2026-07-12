<?php

declare(strict_types=1);

namespace App\Application\Menu\Entity\Combo;

/**
 * Комбо — продаваемый набор товаров меню по единой цене (сумма товаров минус скидка).
 * Создаётся владельцем вручную; externalId заложен на будущий импорт из POS, поэтому
 * исчезнувшие комбо архивируются, а не удаляются. isAvailable — ручной стоп владельца.
 */
class Combo
{
    /**
     * @param ComboItem[] $items
     */
    public function __construct(
        public ?int $id,
        public int $venueId,
        public string $externalId,
        public string $name,
        public string $description,
        public ComboDiscountTypeEnum $discountType,
        public int $discountValue,
        public array $items,
        public int $position,
        public bool $isAvailable,
        public bool $isArchived,
    ) {}

    /**
     * @param ComboItem[] $items
     */
    public static function buildNew(
        int $venueId,
        string $externalId,
        string $name,
        string $description,
        ComboDiscountTypeEnum $discountType,
        int $discountValue,
        array $items,
        int $position,
        bool $isAvailable,
    ): self {
        self::guard($name, $discountType, $discountValue, $items);

        return new self(
            id: null,
            venueId: $venueId,
            externalId: $externalId,
            name: $name,
            description: $description,
            discountType: $discountType,
            discountValue: $discountValue,
            items: $items,
            position: $position,
            isAvailable: $isAvailable,
            isArchived: false,
        );
    }

    /**
     * @param ComboItem[] $items
     */
    public function update(
        string $name,
        string $description,
        ComboDiscountTypeEnum $discountType,
        int $discountValue,
        array $items,
        int $position,
        bool $isAvailable,
    ): void {
        self::guard($name, $discountType, $discountValue, $items);

        $this->name = $name;
        $this->description = $description;
        $this->discountType = $discountType;
        $this->discountValue = $discountValue;
        $this->items = $items;
        $this->position = $position;
        $this->isAvailable = $isAvailable;
        $this->isArchived = false;
    }

    public function archive(): void
    {
        $this->isArchived = true;
        $this->isAvailable = false;
    }

    public function assignId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param ComboItem[] $items
     */
    private static function guard(
        string $name,
        ComboDiscountTypeEnum $discountType,
        int $discountValue,
        array $items,
    ): void {
        if (trim($name) === '') {
            throw new \DomainException('Укажите название комбо');
        }

        if ($items === []) {
            throw new \DomainException('Добавьте товары в комбо');
        }

        if ($discountValue < 0) {
            throw new \DomainException('Скидка комбо не может быть отрицательной');
        }

        if ($discountType === ComboDiscountTypeEnum::Percent && $discountValue > 100) {
            throw new \DomainException('Процент скидки комбо не может превышать 100');
        }
    }
}
