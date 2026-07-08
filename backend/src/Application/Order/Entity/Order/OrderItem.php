<?php

declare(strict_types=1);

namespace App\Application\Order\Entity\Order;

/**
 * Позиция заказа — снимок позиции меню на момент оформления: название и цены
 * зафиксированы, чтобы последующее изменение меню не меняло сумму заказа.
 * Итог строки = (цена позиции + сумма модификаторов) × количество.
 */
final class OrderItem
{
    /**
     * @param OrderItemModifier[] $modifiers
     */
    public function __construct(
        public readonly string $menuItemExternalId,
        public readonly string $name,
        public readonly int $unitPriceKopecks,
        public readonly int $quantity,
        public readonly array $modifiers,
    ) {}

    public function lineTotalKopecks(): int
    {
        $modifiersTotal = 0;

        foreach ($this->modifiers as $modifier) {
            $modifiersTotal += $modifier->priceKopecks;
        }

        return ($this->unitPriceKopecks + $modifiersTotal) * $this->quantity;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'menu_item_external_id' => $this->menuItemExternalId,
            'name' => $this->name,
            'unit_price_kopecks' => $this->unitPriceKopecks,
            'quantity' => $this->quantity,
            'modifiers' => array_map(
                static fn(OrderItemModifier $modifier): array => $modifier->toArray(),
                $this->modifiers,
            ),
        ];
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            menuItemExternalId: (string) $data['menu_item_external_id'],
            name: (string) $data['name'],
            unitPriceKopecks: (int) $data['unit_price_kopecks'],
            quantity: (int) $data['quantity'],
            modifiers: array_map(
                static fn(array $modifier): OrderItemModifier => OrderItemModifier::fromArray($modifier),
                $data['modifiers'] ?? [],
            ),
        );
    }
}
