<?php

declare(strict_types=1);

namespace App\Http\Action\Venue;

use App\Application\Venue\Query\GetVenuesByWorkspace\Fetcher as GetVenuesByWorkspaceFetcher;
use App\Application\Venue\Query\GetVenuesByWorkspace\Query as GetVenuesByWorkspaceQuery;
use App\Application\Venue\Query\VenueView;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetVenuesByWorkspaceAction extends AbstractController
{
    public function __construct(
        private readonly GetVenuesByWorkspaceFetcher $getVenuesByWorkspace,
    ) {}

    #[Route('/workspaces/{workspaceId}/venues', name: 'app_get_venues_by_workspace', methods: ['GET'], requirements: ['workspaceId' => '\d+'])]
    public function handle(Request $request, int $workspaceId): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $venues = $this->getVenuesByWorkspace->fetch(
                new GetVenuesByWorkspaceQuery(
                    userId: $user->claims->userId,
                    workspaceId: $workspaceId,
                ),
            );

            return ApiResponse::success([
                'venues' => array_map(
                    fn(VenueView $venue): array => $venue->toArray(),
                    $venues,
                ),
            ]);
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'venue/get-by-workspace',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
