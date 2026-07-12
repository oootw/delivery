<?php

declare(strict_types=1);

namespace App\Application\Menu\Entity\Combo;

/**
 * Строка состава комбо: товар меню (по externalId) и его количество в наборе.
 * Цены здесь нет — она берётся из актуального меню в момент расчёта.
 */
final class ComboItem
{
    public function __construct(
        public readonly string $itemExternalId,
        public readonly int $quantity,
    ) {
        if ($this->itemExternalId === '') {
            throw new \DomainException('У товара комбо нет идентификатора');
        }

        if ($this->quantity < 1) {
            throw new \DomainException('Количество товара в комбо должно быть больше нуля');
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'item_external_id' => $this->itemExternalId,
            'quantity' => $this->quantity,
        ];
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            itemExternalId: (string) $data['item_external_id'],
            quantity: (int) $data['quantity'],
        );
    }
}
