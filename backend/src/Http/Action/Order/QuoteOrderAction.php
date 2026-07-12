<?php

declare(strict_types=1);

namespace App\Http\Action\Order;

use App\Application\Order\Pricing\CartLine;
use App\Application\Order\Pricing\ComboCartLine;
use App\Application\Order\Query\QuoteOrder\QuoteOrderFetcher;
use App\Application\Order\Query\QuoteOrder\QuoteOrderQuery;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

/**
 * Предпросмотр цены до оформления: та же корзина, промокод и баллы, что и в заказе,
 * но заказ не создаётся. Итог совпадает с PlaceOrder — расчёт общий.
 */
class QuoteOrderAction extends AbstractController
{
    public function __construct(
        private readonly QuoteOrderFetcher $quoteOrder,
    ) {}

    #[Route('/venues/{venueId}/orders/quote', name: 'app_quote_order', methods: ['POST'], requirements: ['venueId' => '\d+'])]
    public function handle(Request $request, int $venueId): Response
    {
        try {
            $body = $request->toArray();

            $type = $body['type'] ?? null;
            $items = $body['items'] ?? [];
            $combos = $body['combos'] ?? [];

            Assert::notEmpty($type, 'Укажите тип заказа');
            Assert::isArray($items, 'Некорректные позиции заказа');
            Assert::isArray($combos, 'Некорректные комбо заказа');
            Assert::false($items === [] && $combos === [], 'Заказ пустой');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $quote = $this->quoteOrder->fetch(
                new QuoteOrderQuery(
                    venueId: $venueId,
                    customerId: $user->claims->userId,
                    type: $type,
                    lines: $this->readLines($items),
                    promocode: $body['promocode'] ?? null,
                    pointsToSpend: $body['points_to_spend'] ?? null,
                    comboLines: $this->readComboLines($combos),
                ),
            );

            return ApiResponse::success($quote);
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'order/quote',
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
