<?php

declare(strict_types=1);

namespace App\Http\Action\Menu;

use App\Application\Menu\Command\DeleteMenuImage\DeleteMenuImageCommand;
use App\Application\Menu\Command\DeleteMenuImage\DeleteMenuImageHandler;
use App\Application\Menu\Image\MenuImageKind;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeleteMenuImageAction extends AbstractController
{
    public function __construct(
        private readonly DeleteMenuImageHandler $deleteMenuImage,
    ) {}

    #[Route(
        '/venues/{venueId}/menu-images/{kind}/{id}',
        name: 'app_delete_menu_image',
        methods: ['DELETE'],
        requirements: ['venueId' => '\d+', 'kind' => 'category|modifier-group|modifier|combo', 'id' => '\d+'],
    )]
    public function handle(int $venueId, string $kind, int $id): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->deleteMenuImage->handle(
                new DeleteMenuImageCommand(
                    userId: $user->claims->userId,
                    venueId: $venueId,
                    kind: MenuImageKind::from($kind),
                    entityId: $id,
                ),
            );

            return ApiResponse::success();
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'menu/image-delete',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
