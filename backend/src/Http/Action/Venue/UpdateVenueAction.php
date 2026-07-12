<?php

declare(strict_types=1);

namespace App\Http\Action\Venue;

use App\Application\Venue\Command\UpdateVenue\UpdateVenueCommand;
use App\Application\Venue\Command\UpdateVenue\UpdateVenueHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

/**
 * Полная замена основных данных точки (кроме часов работы и активности —
 * для них отдельные эндпоинты). Часы работы здесь не трогаем.
 */
class UpdateVenueAction extends AbstractController
{
    public function __construct(
        private readonly UpdateVenueHandler $updateVenue,
    ) {}

    #[Route('/venues/{venueId}', name: 'app_update_venue', methods: ['PUT'], requirements: ['venueId' => '\d+'])]
    public function handle(Request $request, int $venueId): Response
    {
        try {
            $body = $request->toArray();

            $name = $body['name'] ?? null;
            $address = $body['address'] ?? null;

            Assert::notEmpty($name, 'Укажите название точки');
            Assert::notEmpty($address, 'Укажите адрес точки');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->updateVenue->handle(
                new UpdateVenueCommand(
                    ownerId: $user->claims->userId,
                    venueId: $venueId,
                    name: $name,
                    address: $address,
                    latitude: $body['latitude'] ?? null,
                    longitude: $body['longitude'] ?? null,
                    phone: $body['phone'] ?? null,
                    supportsDelivery: $body['supports_delivery'] ?? true,
                    supportsPickup: $body['supports_pickup'] ?? true,
                    deliveryRadiusMeters: $body['delivery_radius_meters'] ?? null,
                    timezone: $body['timezone'] ?? null,
                ),
            );

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'venue/update',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
