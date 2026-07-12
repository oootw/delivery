<?php

declare(strict_types=1);

namespace App\Http\Action\Menu;

use App\Application\Menu\Command\SetMenuItemNutrition\SetMenuItemNutritionCommand;
use App\Application\Menu\Command\SetMenuItemNutrition\SetMenuItemNutritionHandler;
use App\Application\Menu\Nutrition\Nutrition;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SetMenuItemNutritionAction extends AbstractController
{
    public function __construct(
        private readonly SetMenuItemNutritionHandler $setMenuItemNutrition,
    ) {}

    #[Route(
        '/venues/{venueId}/menu/items/{itemId}/nutrition',
        name: 'app_set_menu_item_nutrition',
        methods: ['PUT'],
        requirements: ['venueId' => '\d+', 'itemId' => '\d+'],
    )]
    public function handle(Request $request, int $venueId, int $itemId): Response
    {
        try {
            $body = $request->toArray();

            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->setMenuItemNutrition->handle(
                new SetMenuItemNutritionCommand(
                    userId: $user->claims->userId,
                    venueId: $venueId,
                    itemId: $itemId,
                    nutrition: Nutrition::fromArray($body),
                ),
            );

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'menu/item-nutrition',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
