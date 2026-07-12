<?php

declare(strict_types=1);

namespace App\Http\Action\Promotion;

use App\Application\Promotion\Command\SetPromotionBanner\SetPromotionBannerCommand;
use App\Application\Promotion\Command\SetPromotionBanner\SetPromotionBannerHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SetPromotionBannerAction extends AbstractController
{
    public function __construct(
        private readonly SetPromotionBannerHandler $setPromotionBanner,
    ) {}

    #[Route('/promotions/{promotionId}/banner', name: 'app_set_promotion_banner', methods: ['PUT'], requirements: ['promotionId' => '\d+'])]
    public function handle(Request $request, int $promotionId): Response
    {
        try {
            $body = $request->toArray();

            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->setPromotionBanner->handle(
                new SetPromotionBannerCommand(
                    userId: $user->claims->userId,
                    promotionId: $promotionId,
                    bannerTitle: $body['banner_title'] ?? null,
                    bannerText: $body['banner_text'] ?? null,
                ),
            );

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'promotion/banner-set',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
