<?php

declare(strict_types=1);

namespace App\Http\Action\Order;

use App\Application\Order\Command\PlaceOrder\PlaceOrderCommand;
use App\Application\Order\Command\PlaceOrder\PlaceOrderHandler;
use App\Application\Order\Pricing\CartLine;
use App\Application\Order\Pricing\ComboCartLine;
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
    ) {}

    #[Route('/venues/{venueId}/orders', name: 'app_place_order', methods: ['POST'], requirements: ['venueId' => '\d+'])]
    public function handle(Request $request, int $venueId): Response
    {
        try {
            $body = $request->toArray();

            $type = $body['type'] ?? null;
            $items = $body['items'] ?? [];
            $combos = $body['combos'] ?? [];
            $contactName = $body['contact_name'] ?? null;
            $contactPhone = $body['contact_phone'] ?? null;

            Assert::notEmpty($type, 'Укажите тип заказа');
            Assert::isArray($items, 'Некорректные позиции заказа');
            Assert::isArray($combos, 'Некорректные комбо заказа');
            Assert::false($items === [] && $combos === [], 'Заказ пустой');
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
                    promocode: $body['promocode'] ?? null,
                    pointsToSpend: $body['points_to_spend'] ?? null,
                    comboLines: $this->readComboLines($combos),
                ),
            );

            $response = [
                'order_id' => $placedOrder->orderId,
                'realtime_topic' => 'orders/' . $placedOrder->orderId,
                'payment_required' => $placedOrder->paymentRequired,
            ];

            // Бесплатный заказ уже оплачен на сервере — инструкция оплаты не нужна.
            // Иначе отдаём провайдер-зависимую инструкцию (виджет CP / embedded ЮKassa).
            if ($placedOrder->paymentInstruction !== null) {
                $response['payment'] = $placedOrder->paymentInstruction->toArray();
            }

            return ApiResponse::success($response);
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
     * @return CartLine[]
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

            $lines[] = new CartLine(
                menuItemExternalId: (string) $menuItemExternalId,
                quantity: $quantity,
                modifierExternalIds: array_map('strval', $item['modifiers'] ?? []),
            );
        }

        return $lines;
    }

    /**
     * @param array<int, mixed> $combos
     * @return ComboCartLine[]
     */
    private function readComboLines(array $combos): array
    {
        $lines = [];

        foreach ($combos as $combo) {
            Assert::isArray($combo, 'Некорректное комбо заказа');

            $comboExternalId = $combo['combo_external_id'] ?? null;
            $quantity = $combo['quantity'] ?? null;

            Assert::notEmpty($comboExternalId, 'У комбо нет идентификатора');
            Assert::integer($quantity, 'Количество должно быть числом');

            $lines[] = new ComboCartLine(
                comboExternalId: (string) $comboExternalId,
                quantity: $quantity,
            );
        }

        return $lines;
    }
}
