<?php

declare(strict_types=1);

namespace App\Http\Action\Menu\Client;

use App\Application\Menu\Query\GetClientVenuesByWorkspaceId\GetClientVenuesByWorkspaceIdFetcher;
use App\Application\Menu\Query\GetClientVenuesByWorkspaceId\GetClientVenuesByWorkspaceIdQuery;
use App\Http\Response\ApiResponse;
use App\Http\Workspace\WorkspaceContext;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetClientVenuesAction extends AbstractController
{
    public function __construct(
        private readonly GetClientVenuesByWorkspaceIdFetcher $getClientVenues,
        private readonly WorkspaceContext $workspaceContext,
    ) {}

    #[Route('/menu/venues', name: 'app_client_venues', methods: ['GET'])]
    public function handle(): Response
    {
        try {
            $venues = $this->getClientVenues->fetch(
                new GetClientVenuesByWorkspaceIdQuery(workspaceSlug: $this->workspaceContext->getSlug()),
            );

            return ApiResponse::success(['venues' => $venues]);
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'menu/client-venues',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
