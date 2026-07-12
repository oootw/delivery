<?php

declare(strict_types=1);

namespace App\Http\Action\Promotion;

use App\Application\Promotion\Query\GetActivePromotionsByVenueId\GetActivePromotionsByVenueIdFetcher;
use App\Application\Promotion\Query\GetActivePromotionsByVenueId\GetActivePromotionsByVenueIdQuery;
use App\Http\Response\ApiResponse;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Витрина акций точки для гостя: активные автоматические скидки. Промокоды не отдаются.
 */
class GetActivePromotionsAction extends AbstractController
{
    public function __construct(
        private readonly GetActivePromotionsByVenueIdFetcher $getActivePromotions,
    ) {}

    #[Route('/venues/{venueId}/promotions', name: 'app_get_active_promotions', methods: ['GET'], requirements: ['venueId' => '\d+'])]
    public function handle(int $venueId): Response
    {
        try {
            $promotions = $this->getActivePromotions->fetch(
                new GetActivePromotionsByVenueIdQuery(venueId: $venueId),
            );

            return ApiResponse::success(['promotions' => $promotions]);
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'promotion/showcase',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
