<?php

declare(strict_types=1);

namespace App\Http\Action\Venue;

use App\Application\Venue\Command\ChangeVenueActivity\ChangeVenueActivityCommand;
use App\Application\Venue\Command\ChangeVenueActivity\ChangeVenueActivityHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class ChangeVenueActivityAction extends AbstractController
{
    public function __construct(
        private readonly ChangeVenueActivityHandler $changeVenueActivity,
    ) {}

    #[Route('/venues/{venueId}/activation', name: 'app_change_venue_activity', methods: ['POST'], requirements: ['venueId' => '\d+'])]
    public function handle(Request $request, int $venueId): Response
    {
        try {
            $body = $request->toArray();

            $isActive = $body['is_active'] ?? null;

            Assert::boolean($isActive, 'Поле is_active должно быть булевым');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->changeVenueActivity->handle(
                new ChangeVenueActivityCommand(
                    ownerId: $user->claims->userId,
                    venueId: $venueId,
                    isActive: $isActive,
                ),
            );

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'venue/change-activity',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
