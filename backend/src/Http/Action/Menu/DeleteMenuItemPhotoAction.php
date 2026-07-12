<?php

declare(strict_types=1);

namespace App\Http\Action\Menu;

use App\Application\Menu\Command\DeleteMenuItemPhoto\DeleteMenuItemPhotoCommand;
use App\Application\Menu\Command\DeleteMenuItemPhoto\DeleteMenuItemPhotoHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeleteMenuItemPhotoAction extends AbstractController
{
    public function __construct(
        private readonly DeleteMenuItemPhotoHandler $deleteMenuItemPhoto,
    ) {}

    #[Route(
        '/venues/{venueId}/menu/items/{itemId}/photos/{index}',
        name: 'app_delete_menu_item_photo',
        methods: ['DELETE'],
        requirements: ['venueId' => '\d+', 'itemId' => '\d+', 'index' => '\d+'],
    )]
    public function handle(int $venueId, int $itemId, int $index): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->deleteMenuItemPhoto->handle(
                new DeleteMenuItemPhotoCommand(
                    userId: $user->claims->userId,
                    venueId: $venueId,
                    itemId: $itemId,
                    index: $index,
                ),
            );

            return ApiResponse::success();
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'menu/item-photo-delete',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
