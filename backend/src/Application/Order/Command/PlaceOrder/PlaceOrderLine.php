<?php

declare(strict_types=1);

namespace App\Application\Order\Command\PlaceOrder;

/**
 * Строка корзины из запроса: что и сколько заказывают, какие модификаторы выбраны.
 * Цены здесь нет — сервер берёт актуальную цену из меню, чтобы гость не мог её подменить.
 */
final class PlaceOrderLine
{
    /**
     * @param string[] $modifierExternalIds
     */
    public function __construct(
        public readonly string $menuItemExternalId,
        public readonly int $quantity,
        public readonly array $modifierExternalIds,
    ) {}
}
