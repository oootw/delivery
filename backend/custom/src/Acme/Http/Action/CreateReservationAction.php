<?php

declare(strict_types=1);

namespace App\Custom\Acme\Http\Action;

use App\Custom\Acme\Command\CreateReservation\CreateReservationCommand;
use App\Custom\Acme\Command\CreateReservation\CreateReservationHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class CreateReservationAction extends AbstractController
{
    public function __construct(
        private readonly CreateReservationHandler $createReservation,
    ) {}

    #[Route('/workspaces/{workspaceId}/acme/reservations', name: 'custom_acme_create_reservation', methods: ['POST'], requirements: ['workspaceId' => '\d+'])]
    public function handle(Request $request, int $workspaceId): Response
    {
        try {
            $body = $request->toArray();

            $venueId = $body['venue_id'] ?? null;
            $guestName = $body['guest_name'] ?? null;
            $guestPhone = $body['guest_phone'] ?? null;
            $peopleCount = $body['people_count'] ?? null;
            $desiredAt = $body['desired_at'] ?? null;

            Assert::integer($venueId, 'Укажите venue_id');
            Assert::stringNotEmpty($guestName, 'Укажите имя гостя');
            Assert::stringNotEmpty($guestPhone, 'Укажите телефон гостя');
            Assert::integer($peopleCount, 'Укажите число гостей');
            Assert::stringNotEmpty($desiredAt, 'Укажите время визита (ISO 8601)');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $id = $this->createReservation->handle(
                new CreateReservationCommand(
                    userId: $user->claims->userId,
                    workspaceId: $workspaceId,
                    venueId: $venueId,
                    guestName: $guestName,
                    guestPhone: $guestPhone,
                    peopleCount: $peopleCount,
                    desiredAt: new \DateTimeImmutable($desiredAt),
                ),
            );

            return ApiResponse::success(['id' => $id]);
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'custom/acme/create-reservation',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
