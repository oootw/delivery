<?php

declare(strict_types=1);

namespace App\Http\Action\Promotion;

use App\Application\Promotion\Query\GetPromotionById\GetPromotionByIdFetcher;
use App\Application\Promotion\Query\GetPromotionById\GetPromotionByIdQuery;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetPromotionAction extends AbstractController
{
    public function __construct(
        private readonly GetPromotionByIdFetcher $getPromotion,
    ) {}

    #[Route('/promotions/{promotionId}', name: 'app_get_promotion', methods: ['GET'], requirements: ['promotionId' => '\d+'])]
    public function handle(int $promotionId): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $promotion = $this->getPromotion->fetch(
                new GetPromotionByIdQuery(
                    userId: $user->claims->userId,
                    promotionId: $promotionId,
                ),
            );

            return ApiResponse::success(['promotion' => $promotion]);
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'promotion/get',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
