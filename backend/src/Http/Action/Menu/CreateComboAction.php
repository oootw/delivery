<?php

declare(strict_types=1);

namespace App\Http\Action\Menu;

use App\Application\Menu\Command\CreateCombo\CreateComboCommand;
use App\Application\Menu\Command\CreateCombo\CreateComboHandler;
use App\Application\Menu\Entity\Combo\ComboDiscountTypeEnum;
use App\Application\Menu\Entity\Combo\ComboItem;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class CreateComboAction extends AbstractController
{
    public function __construct(
        private readonly CreateComboHandler $createCombo,
    ) {}

    #[Route('/venues/{venueId}/combos', name: 'app_create_combo', methods: ['POST'], requirements: ['venueId' => '\d+'])]
    public function handle(Request $request, int $venueId): Response
    {
        try {
            $body = $request->toArray();

            $name = $body['name'] ?? null;
            Assert::notEmpty($name, 'Укажите название комбо');

            $discountType = ComboDiscountTypeEnum::tryFrom((string) ($body['discount_type'] ?? ''));
            Assert::notNull($discountType, 'Неизвестный тип скидки комбо');

            $items = $body['items'] ?? null;
            Assert::isArray($items, 'Добавьте товары в комбо');
            Assert::notEmpty($items, 'Добавьте товары в комбо');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $comboId = $this->createCombo->handle(
                new CreateComboCommand(
                    userId: $user->claims->userId,
                    venueId: $venueId,
                    name: (string) $name,
                    description: (string) ($body['description'] ?? ''),
                    discountType: $discountType,
                    discountValue: (int) ($body['discount_value'] ?? 0),
                    items: ComboItemsInput::read($items),
                    position: (int) ($body['position'] ?? 0),
                    isAvailable: (bool) ($body['is_available'] ?? true),
                ),
            );

            return ApiResponse::success(['combo_id' => $comboId]);
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'menu/combo-create',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
