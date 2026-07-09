<?php

declare(strict_types=1);

namespace App\Http\Action\Promotion;

use App\Application\Promotion\Command\CreatePromotion\Command as CreatePromotionCommand;
use App\Application\Promotion\Command\CreatePromotion\Handler as CreatePromotionHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class CreatePromotionAction extends AbstractController
{
    public function __construct(
        private readonly CreatePromotionHandler $createPromotion,
    ) {}

    #[Route('/workspaces/{workspaceId}/promotions', name: 'app_create_promotion', methods: ['POST'], requirements: ['workspaceId' => '\d+'])]
    public function handle(Request $request, int $workspaceId): Response
    {
        try {
            $body = $request->toArray();

            $name = $body['name'] ?? null;
            $type = $body['type'] ?? null;
            $rewardType = $body['reward_type'] ?? null;
            $rewardValue = $body['reward_value'] ?? null;

            Assert::notEmpty($name, 'Укажите название акции');
            Assert::notEmpty($type, 'Укажите тип акции');
            Assert::notEmpty($rewardType, 'Укажите тип скидки');
            Assert::integer($rewardValue, 'Размер скидки должен быть числом');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $created = $this->createPromotion->handle(
                new CreatePromotionCommand(
                    ownerId: $user->claims->userId,
                    workspaceId: $workspaceId,
                    venueId: $body['venue_id'] ?? null,
                    name: $name,
                    type: $type,
                    code: $body['code'] ?? null,
                    rewardType: $rewardType,
                    rewardValue: $rewardValue,
                    target: $body['target'] ?? 'order',
                    targetRefs: $body['target_refs'] ?? [],
                    priority: $body['priority'] ?? 0,
                    stackable: $body['stackable'] ?? false,
                    maxRedemptions: $body['max_redemptions'] ?? null,
                    maxRedemptionsPerCustomer: $body['max_redemptions_per_customer'] ?? null,
                    conditions: $body['conditions'] ?? [],
                ),
            );

            return ApiResponse::success([
                'promotion' => ['id' => $created->id],
            ]);
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'promotion/create',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
