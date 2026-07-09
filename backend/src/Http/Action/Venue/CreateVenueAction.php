<?php

declare(strict_types=1);

namespace App\Http\Action\Venue;

use App\Application\Venue\Command\CreateVenue\Command as CreateVenueCommand;
use App\Application\Venue\Command\CreateVenue\Handler as CreateVenueHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class CreateVenueAction extends AbstractController
{
    public function __construct(
        private readonly CreateVenueHandler $createVenue,
    ) {}

    #[Route('/workspaces/{workspaceId}/venues', name: 'app_create_venue', methods: ['POST'], requirements: ['workspaceId' => '\d+'])]
    public function handle(Request $request, int $workspaceId): Response
    {
        try {
            $body = $request->toArray();

            $name = $body['name'] ?? null;
            $address = $body['address'] ?? null;

            Assert::notEmpty($name, 'Укажите название точки');
            Assert::notEmpty($address, 'Укажите адрес точки');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $createdVenue = $this->createVenue->handle(
                new CreateVenueCommand(
                    ownerId: $user->claims->userId,
                    workspaceId: $workspaceId,
                    name: $name,
                    address: $address,
                    latitude: $body['latitude'] ?? null,
                    longitude: $body['longitude'] ?? null,
                    phone: $body['phone'] ?? null,
                    supportsDelivery: $body['supports_delivery'] ?? true,
                    supportsPickup: $body['supports_pickup'] ?? true,
                    deliveryRadiusMeters: $body['delivery_radius_meters'] ?? null,
                    workingHours: $body['working_hours'] ?? [],
                    timezone: $body['timezone'] ?? null,
                ),
            );

            return ApiResponse::success([
                'venue' => ['id' => $createdVenue->id],
            ]);
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'venue/create',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
