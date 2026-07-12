<?php

declare(strict_types=1);

namespace App\Http\Action\Menu;

use App\Application\Menu\Command\AddMenuItemPhoto\AddMenuItemPhotoCommand;
use App\Application\Menu\Command\AddMenuItemPhoto\AddMenuItemPhotoHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddMenuItemPhotoAction extends AbstractController
{
    private const MAX_SIZE_BYTES = 5 * 1024 * 1024;

    /** Детектируемый по содержимому MIME → расширение файла. */
    private const MIME_EXTENSIONS = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
    ];

    public function __construct(
        private readonly AddMenuItemPhotoHandler $addMenuItemPhoto,
    ) {}

    #[Route(
        '/venues/{venueId}/menu/items/{itemId}/photos',
        name: 'app_add_menu_item_photo',
        methods: ['POST'],
        requirements: ['venueId' => '\d+', 'itemId' => '\d+'],
    )]
    public function handle(Request $request, int $venueId, int $itemId): Response
    {
        try {
            $file = $request->files->get('photo');

            if (!$file instanceof UploadedFile || !$file->isValid()) {
                return ApiResponse::error('Прикрепите файл фото в поле photo');
            }

            if ($file->getSize() > self::MAX_SIZE_BYTES) {
                return ApiResponse::error('Файл больше 5 МБ');
            }

            $extension = self::MIME_EXTENSIONS[$file->getMimeType()] ?? null;

            if ($extension === null) {
                return ApiResponse::error('Допустимы только JPEG и PNG');
            }

            /** @var JwtUser $user */
            $user = $this->getUser();

            $photo = $this->addMenuItemPhoto->handle(
                new AddMenuItemPhotoCommand(
                    userId: $user->claims->userId,
                    venueId: $venueId,
                    itemId: $itemId,
                    sourcePath: $file->getPathname(),
                    extension: $extension,
                ),
            );

            return ApiResponse::success(['index' => $photo['index'], 'photo_url' => $photo['url']]);
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'menu/item-photo-add',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
