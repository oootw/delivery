<?php

declare(strict_types=1);

namespace App\Http\Action\Venue;

use App\Application\Venue\Query\GetVenueLogoByVenueId\GetVenueLogoByVenueIdFetcher;
use App\Application\Venue\Query\GetVenueLogoByVenueId\GetVenueLogoByVenueIdQuery;
use App\Http\Response\ApiResponse;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetVenueLogoAction extends AbstractController
{
    public function __construct(
        private readonly GetVenueLogoByVenueIdFetcher $getVenueLogo,
    ) {}

    #[Route('/venues/{venueId}/logo', name: 'app_get_venue_logo', methods: ['GET'], requirements: ['venueId' => '\d+'])]
    public function handle(int $venueId): Response
    {
        try {
            $logo = $this->getVenueLogo->fetch(
                new GetVenueLogoByVenueIdQuery(venueId: $venueId),
            );

            return ApiResponse::success($logo);
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'venue/logo-get',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
