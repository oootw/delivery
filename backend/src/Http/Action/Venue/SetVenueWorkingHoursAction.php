<?php

declare(strict_types=1);

namespace App\Http\Action\Venue;

use App\Application\Venue\Command\SetVenueWorkingHours\Command as SetVenueWorkingHoursCommand;
use App\Application\Venue\Command\SetVenueWorkingHours\Handler as SetVenueWorkingHoursHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SetVenueWorkingHoursAction extends AbstractController
{
    public function __construct(
        private readonly SetVenueWorkingHoursHandler $setVenueWorkingHours,
    ) {}

    #[Route('/venues/{venueId}/working-hours', name: 'app_set_venue_working_hours', methods: ['PUT'], requirements: ['venueId' => '\d+'])]
    public function handle(Request $request, int $venueId): Response
    {
        try {
            $body = $request->toArray();

            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->setVenueWorkingHours->handle(
                new SetVenueWorkingHoursCommand(
                    ownerId: $user->claims->userId,
                    venueId: $venueId,
                    workingHours: $body['working_hours'] ?? [],
                ),
            );

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'venue/set-working-hours',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
