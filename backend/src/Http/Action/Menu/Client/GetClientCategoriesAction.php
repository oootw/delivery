<?php

declare(strict_types=1);

namespace App\Http\Action\Menu\Client;

use App\Application\Menu\Query\GetClientCategoriesByVenueId\GetClientCategoriesByVenueIdFetcher;
use App\Application\Menu\Query\GetClientCategoriesByVenueId\GetClientCategoriesByVenueIdQuery;
use App\Http\Response\ApiResponse;
use App\Http\Workspace\WorkspaceContext;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetClientCategoriesAction extends AbstractController
{
    public function __construct(
        private readonly GetClientCategoriesByVenueIdFetcher $getClientCategories,
        private readonly WorkspaceContext $workspaceContext,
    ) {}

    #[Route('/menu/venues/{venueId}/categories', name: 'app_client_categories', methods: ['GET'], requirements: ['venueId' => '\d+'])]
    public function handle(int $venueId): Response
    {
        try {
            $categories = $this->getClientCategories->fetch(
                new GetClientCategoriesByVenueIdQuery(
                    workspaceId: $this->workspaceContext->getWorkspaceId(),
                    venueId: $venueId,
                ),
            );

            return ApiResponse::success(['categories' => $categories]);
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'menu/client-categories',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
