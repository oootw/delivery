<?php

declare(strict_types=1);

namespace App\Http\Action\Venue;

use App\Application\Venue\Query\GetVenue\Fetcher as GetVenueFetcher;
use App\Application\Venue\Query\GetVenue\Query as GetVenueQuery;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetVenueAction extends AbstractController
{
    public function __construct(
        private readonly GetVenueFetcher $getVenue,
    ) {}

    #[Route('/venues/{venueId}', name: 'app_get_venue', methods: ['GET'], requirements: ['venueId' => '\d+'])]
    public function handle(int $venueId): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $venue = $this->getVenue->fetch(
                new GetVenueQuery(
                    userId: $user->claims->userId,
                    venueId: $venueId,
                ),
            );

            return ApiResponse::success(['venue' => $venue->toArray()]);
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'venue/get',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
