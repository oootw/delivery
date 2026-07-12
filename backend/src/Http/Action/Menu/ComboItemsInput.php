<?php

declare(strict_types=1);

namespace App\Http\Action\Menu;

use App\Application\Menu\Entity\Combo\ComboItem;
use Webmozart\Assert\Assert;

/**
 * Разбор состава комбо из тела запроса в ComboItem[]. Общий для создания и обновления.
 */
final class ComboItemsInput
{
    /**
     * @param array<int, mixed> $items
     * @return ComboItem[]
     */
    public static function read(array $items): array
    {
        $result = [];

        foreach ($items as $item) {
            Assert::isArray($item, 'Некорректный товар комбо');

            $itemExternalId = $item['item_external_id'] ?? null;
            $quantity = $item['quantity'] ?? 1;

            Assert::notEmpty($itemExternalId, 'У товара комбо нет идентификатора');
            Assert::integer($quantity, 'Количество товара комбо должно быть числом');

            $result[] = new ComboItem(
                itemExternalId: (string) $itemExternalId,
                quantity: $quantity,
            );
        }

        return $result;
    }
}
