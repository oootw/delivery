<?php

declare(strict_types=1);

namespace App\Application\Order\Query;

use App\Application\Order\Entity\Order\Order;
use App\Application\Order\Entity\Order\OrderItem;

/**
 * Единый read-model заказа для ответов API. Собирает заказ в массив с позициями,
 * модификаторами, историей статусов и оценкой времени ожидания.
 */
final class OrderView
{
    /**
     * @return array<string, mixed>
     */
    public static function fromOrder(Order $order): array
    {
        return [
            'id' => $order->id,
            'workspace_id' => $order->workspaceId,
            'venue_id' => $order->venueId,
            'customer_id' => $order->customerId,
            'type' => $order->type->value,
            'status' => $order->status->value,
            'total_kopecks' => $order->totalKopecks,
            'contact_name' => $order->contactName,
            'contact_phone' => $order->contactPhone,
            'delivery_address' => $order->deliveryAddress,
            'comment' => $order->comment,
            'estimated_wait_minutes' => $order->estimatedWaitMinutes,
            'items' => array_map(
                static fn(OrderItem $item): array => $item->toArray() + ['line_total_kopecks' => $item->lineTotalKopecks()],
                $order->items,
            ),
            'history' => $order->history,
            'created_at' => $order->createdAt->format(\DateTimeInterface::ATOM),
            'updated_at' => $order->updatedAt->format(\DateTimeInterface::ATOM),
        ];
    }
}
