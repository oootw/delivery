<?php

declare(strict_types=1);

namespace App\Http\Action\Promotion;

use App\Application\Promotion\Command\UpdatePromotion\UpdatePromotionCommand;
use App\Application\Promotion\Command\UpdatePromotion\UpdatePromotionHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class UpdatePromotionAction extends AbstractController
{
    public function __construct(
        private readonly UpdatePromotionHandler $updatePromotion,
    ) {}

    #[Route('/promotions/{promotionId}', name: 'app_update_promotion', methods: ['PUT'], requirements: ['promotionId' => '\d+'])]
    public function handle(Request $request, int $promotionId): Response
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

            $this->updatePromotion->handle(
                new UpdatePromotionCommand(
                    userId: $user->claims->userId,
                    promotionId: $promotionId,
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

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'promotion/update',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
