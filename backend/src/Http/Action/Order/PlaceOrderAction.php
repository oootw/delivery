<?php

declare(strict_types=1);

namespace App\Http\Action\Order;

use App\Application\Order\Command\PlaceOrder\Command as PlaceOrderCommand;
use App\Application\Order\Command\PlaceOrder\Handler as PlaceOrderHandler;
use App\Application\Order\Command\PlaceOrder\PlaceOrderLine;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class PlaceOrderAction extends AbstractController
{
    public function __construct(
        private readonly PlaceOrderHandler $placeOrder,
        private readonly string $cloudPaymentsPublicId,
    ) {}

    #[Route('/venues/{venueId}/orders', name: 'app_place_order', methods: ['POST'], requirements: ['venueId' => '\d+'])]
    public function handle(Request $request, int $venueId): Response
    {
        try {
            $body = $request->toArray();

            $type = $body['type'] ?? null;
            $items = $body['items'] ?? null;
            $contactName = $body['contact_name'] ?? null;
            $contactPhone = $body['contact_phone'] ?? null;

            Assert::notEmpty($type, 'Укажите тип заказа');
            Assert::isArray($items, 'Добавьте позиции в заказ');
            Assert::notEmpty($items, 'Заказ пустой');
            Assert::notEmpty($contactName, 'Укажите имя для заказа');
            Assert::notEmpty($contactPhone, 'Укажите телефон для связи');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $placedOrder = $this->placeOrder->handle(
                new PlaceOrderCommand(
                    customerId: $user->claims->userId,
                    venueId: $venueId,
                    type: $type,
                    lines: $this->readLines($items),
                    contactName: $contactName,
                    contactPhone: $contactPhone,
                    deliveryAddress: $body['delivery_address'] ?? null,
                    comment: $body['comment'] ?? null,
                ),
            );

            return ApiResponse::success([
                'order_id' => $placedOrder->orderId,
                'realtime_topic' => 'orders/' . $placedOrder->orderId,
                'payment' => [
                    'public_id' => $this->cloudPaymentsPublicId,
                    'invoice_id' => $placedOrder->invoiceId,
                    'account_id' => $placedOrder->accountId,
                    'amount' => $placedOrder->amountRubles,
                    'currency' => $placedOrder->currency,
                    'description' => 'Оплата заказа №' . $placedOrder->orderId,
                    'data' => ['kind' => 'order'],
                ],
            ]);
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'order/place',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }

    /**
     * @param array<int, mixed> $items
     * @return PlaceOrderLine[]
     */
    private function readLines(array $items): array
    {
        $lines = [];

        foreach ($items as $item) {
            Assert::isArray($item, 'Некорректная позиция заказа');

            $menuItemExternalId = $item['menu_item_external_id'] ?? null;
            $quantity = $item['quantity'] ?? null;

            Assert::notEmpty($menuItemExternalId, 'У позиции нет идентификатора');
            Assert::integer($quantity, 'Количество должно быть числом');

            $lines[] = new PlaceOrderLine(
                menuItemExternalId: (string) $menuItemExternalId,
                quantity: $quantity,
                modifierExternalIds: array_map('strval', $item['modifiers'] ?? []),
            );
        }

        return $lines;
    }
}
