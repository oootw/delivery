<?php

declare(strict_types=1);

namespace App\Http\Action\Promotion;

use App\Application\Promotion\Command\UploadPromotionBanner\UploadPromotionBannerCommand;
use App\Application\Promotion\Command\UploadPromotionBanner\UploadPromotionBannerHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UploadPromotionBannerAction extends AbstractController
{
    private const MAX_SIZE_BYTES = 5 * 1024 * 1024;

    /** Детектируемый по содержимому MIME → расширение файла. */
    private const MIME_EXTENSIONS = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
    ];

    public function __construct(
        private readonly UploadPromotionBannerHandler $uploadPromotionBanner,
    ) {}

    #[Route('/promotions/{promotionId}/banner/image', name: 'app_upload_promotion_banner', methods: ['POST'], requirements: ['promotionId' => '\d+'])]
    public function handle(Request $request, int $promotionId): Response
    {
        try {
            $file = $request->files->get('image');

            if (!$file instanceof UploadedFile || !$file->isValid()) {
                return ApiResponse::error('Прикрепите файл картинки в поле image');
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

            $imageUrl = $this->uploadPromotionBanner->handle(
                new UploadPromotionBannerCommand(
                    userId: $user->claims->userId,
                    promotionId: $promotionId,
                    sourcePath: $file->getPathname(),
                    extension: $extension,
                ),
            );

            return ApiResponse::success(['image_url' => $imageUrl]);
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'promotion/banner-upload',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
