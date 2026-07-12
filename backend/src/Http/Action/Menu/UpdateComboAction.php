<?php

declare(strict_types=1);

namespace App\Http\Action\Menu;

use App\Application\Menu\Command\UpdateCombo\UpdateComboCommand;
use App\Application\Menu\Command\UpdateCombo\UpdateComboHandler;
use App\Application\Menu\Entity\Combo\ComboDiscountTypeEnum;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class UpdateComboAction extends AbstractController
{
    public function __construct(
        private readonly UpdateComboHandler $updateCombo,
    ) {}

    #[Route('/combos/{comboId}', name: 'app_update_combo', methods: ['PUT'], requirements: ['comboId' => '\d+'])]
    public function handle(Request $request, int $comboId): Response
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

            $this->updateCombo->handle(
                new UpdateComboCommand(
                    userId: $user->claims->userId,
                    comboId: $comboId,
                    name: (string) $name,
                    description: (string) ($body['description'] ?? ''),
                    discountType: $discountType,
                    discountValue: (int) ($body['discount_value'] ?? 0),
                    items: ComboItemsInput::read($items),
                    position: (int) ($body['position'] ?? 0),
                    isAvailable: (bool) ($body['is_available'] ?? true),
                ),
            );

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'menu/combo-update',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
