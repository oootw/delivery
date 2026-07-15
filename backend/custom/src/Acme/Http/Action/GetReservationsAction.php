<?php

declare(strict_types=1);

namespace App\Custom\Acme\Http\Action;

use App\Custom\Acme\Query\GetReservations\GetReservationsFetcher;
use App\Custom\Acme\Query\GetReservations\GetReservationsQuery;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetReservationsAction extends AbstractController
{
    public function __construct(
        private readonly GetReservationsFetcher $getReservations,
    ) {}

    #[Route('/workspaces/{workspaceId}/acme/reservations', name: 'custom_acme_get_reservations', methods: ['GET'], requirements: ['workspaceId' => '\d+'])]
    public function handle(int $workspaceId): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $reservations = $this->getReservations->fetch(
                new GetReservationsQuery(
                    userId: $user->claims->userId,
                    workspaceId: $workspaceId,
                ),
            );

            return ApiResponse::success(['reservations' => $reservations]);
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'custom/acme/get-reservations',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
