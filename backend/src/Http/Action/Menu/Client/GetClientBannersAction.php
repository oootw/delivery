<?php

declare(strict_types=1);

namespace App\Http\Action\Menu\Client;

use App\Application\Menu\Query\GetClientBannersByVenueId\GetClientBannersByVenueIdFetcher;
use App\Application\Menu\Query\GetClientBannersByVenueId\GetClientBannersByVenueIdQuery;
use App\Http\Response\ApiResponse;
use App\Http\Workspace\WorkspaceContext;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetClientBannersAction extends AbstractController
{
    public function __construct(
        private readonly GetClientBannersByVenueIdFetcher $getClientBanners,
        private readonly WorkspaceContext $workspaceContext,
    ) {}

    #[Route('/menu/venues/{venueId}/banners', name: 'app_client_banners', methods: ['GET'], requirements: ['venueId' => '\d+'])]
    public function handle(int $venueId): Response
    {
        try {
            $banners = $this->getClientBanners->fetch(
                new GetClientBannersByVenueIdQuery(
                    workspaceId: $this->workspaceContext->getWorkspaceId(),
                    venueId: $venueId,
                ),
            );

            return ApiResponse::success(['banners' => $banners]);
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'menu/client-banners',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
