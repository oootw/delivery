<?php

declare(strict_types=1);

namespace App\Http\Action\Promotion;

use App\Application\Promotion\Command\ChangePromotionActivity\ChangePromotionActivityCommand;
use App\Application\Promotion\Command\ChangePromotionActivity\ChangePromotionActivityHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class ChangePromotionActivityAction extends AbstractController
{
    public function __construct(
        private readonly ChangePromotionActivityHandler $changePromotionActivity,
    ) {}

    #[Route('/promotions/{promotionId}/activation', name: 'app_change_promotion_activity', methods: ['POST'], requirements: ['promotionId' => '\d+'])]
    public function handle(Request $request, int $promotionId): Response
    {
        try {
            $body = $request->toArray();

            $isActive = $body['is_active'] ?? null;

            Assert::boolean($isActive, 'Укажите is_active (true/false)');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->changePromotionActivity->handle(
                new ChangePromotionActivityCommand(
                    userId: $user->claims->userId,
                    promotionId: $promotionId,
                    isActive: $isActive,
                ),
            );

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'promotion/activation',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
