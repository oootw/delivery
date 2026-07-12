<?php

declare(strict_types=1);

namespace App\Http\Action\Menu;

use App\Application\Menu\Command\UploadMenuImage\UploadMenuImageCommand;
use App\Application\Menu\Command\UploadMenuImage\UploadMenuImageHandler;
use App\Application\Menu\Image\MenuImageKind;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UploadMenuImageAction extends AbstractController
{
    private const MAX_SIZE_BYTES = 5 * 1024 * 1024;

    /** Детектируемый по содержимому MIME → расширение файла. */
    private const MIME_EXTENSIONS = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
    ];

    public function __construct(
        private readonly UploadMenuImageHandler $uploadMenuImage,
    ) {}

    #[Route(
        '/venues/{venueId}/menu-images/{kind}/{id}',
        name: 'app_upload_menu_image',
        methods: ['POST'],
        requirements: ['venueId' => '\d+', 'kind' => 'category|modifier-group|modifier|combo', 'id' => '\d+'],
    )]
    public function handle(Request $request, int $venueId, string $kind, int $id): Response
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

            $photoUrl = $this->uploadMenuImage->handle(
                new UploadMenuImageCommand(
                    userId: $user->claims->userId,
                    venueId: $venueId,
                    kind: MenuImageKind::from($kind),
                    entityId: $id,
                    sourcePath: $file->getPathname(),
                    extension: $extension,
                ),
            );

            return ApiResponse::success(['photo_url' => $photoUrl]);
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'menu/image-upload',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
