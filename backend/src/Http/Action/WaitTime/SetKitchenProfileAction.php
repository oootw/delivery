<?php

declare(strict_types=1);

namespace App\Http\Action\WaitTime;

use App\Application\WaitTime\Command\SetKitchenProfile\Command as SetKitchenProfileCommand;
use App\Application\WaitTime\Command\SetKitchenProfile\Handler as SetKitchenProfileHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class SetKitchenProfileAction extends AbstractController
{
    public function __construct(
        private readonly SetKitchenProfileHandler $setKitchenProfile,
    ) {}

    #[Route('/venues/{venueId}/kitchen-profile', name: 'app_set_kitchen_profile', methods: ['PUT'], requirements: ['venueId' => '\d+'])]
    public function handle(Request $request, int $venueId): Response
    {
        try {
            $body = $request->toArray();

            $baseMinutes = $body['base_minutes'] ?? null;
            $perUnitMinutes = $body['per_unit_minutes'] ?? null;
            $parallelCapacity = $body['parallel_capacity'] ?? null;
            $deliveryMinutes = $body['delivery_minutes'] ?? null;

            Assert::integer($baseMinutes, 'base_minutes — целое число минут');
            Assert::integer($perUnitMinutes, 'per_unit_minutes — целое число минут');
            Assert::integer($parallelCapacity, 'parallel_capacity — целое число');
            Assert::integer($deliveryMinutes, 'delivery_minutes — целое число минут');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->setKitchenProfile->handle(
                new SetKitchenProfileCommand(
                    ownerId: $user->claims->userId,
                    venueId: $venueId,
                    baseMinutes: $baseMinutes,
                    perUnitMinutes: $perUnitMinutes,
                    parallelCapacity: $parallelCapacity,
                    deliveryMinutes: $deliveryMinutes,
                ),
            );

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'wait-time/kitchen-profile',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
