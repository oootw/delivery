<?php

declare(strict_types=1);

namespace App\Http\Action\Promotion;

use App\Application\Promotion\Command\DeletePromotionBanner\DeletePromotionBannerCommand;
use App\Application\Promotion\Command\DeletePromotionBanner\DeletePromotionBannerHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeletePromotionBannerAction extends AbstractController
{
    public function __construct(
        private readonly DeletePromotionBannerHandler $deletePromotionBanner,
    ) {}

    #[Route('/promotions/{promotionId}/banner/image', name: 'app_delete_promotion_banner', methods: ['DELETE'], requirements: ['promotionId' => '\d+'])]
    public function handle(int $promotionId): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->deletePromotionBanner->handle(
                new DeletePromotionBannerCommand(
                    userId: $user->claims->userId,
                    promotionId: $promotionId,
                ),
            );

            return ApiResponse::success();
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'promotion/banner-delete',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
