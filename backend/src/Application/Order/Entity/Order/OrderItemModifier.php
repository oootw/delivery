<?php

declare(strict_types=1);

namespace App\Application\Order\Entity\Order;

/**
 * Выбранный модификатор внутри позиции заказа. Название и цена — снимок на момент
 * оформления: меню в POS может измениться, а заказ должен помнить, за что заплатили.
 */
final class OrderItemModifier
{
    public function __construct(
        public readonly string $externalId,
        public readonly string $name,
        public readonly int $priceKopecks,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'external_id' => $this->externalId,
            'name' => $this->name,
            'price_kopecks' => $this->priceKopecks,
        ];
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            externalId: (string) $data['external_id'],
            name: (string) $data['name'],
            priceKopecks: (int) $data['price_kopecks'],
        );
    }
}
