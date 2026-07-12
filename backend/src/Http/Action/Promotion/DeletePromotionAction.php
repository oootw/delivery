<?php

declare(strict_types=1);

namespace App\Http\Action\Promotion;

use App\Application\Promotion\Command\DeletePromotion\DeletePromotionCommand;
use App\Application\Promotion\Command\DeletePromotion\DeletePromotionHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeletePromotionAction extends AbstractController
{
    public function __construct(
        private readonly DeletePromotionHandler $deletePromotion,
    ) {}

    #[Route('/promotions/{promotionId}', name: 'app_delete_promotion', methods: ['DELETE'], requirements: ['promotionId' => '\d+'])]
    public function handle(int $promotionId): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->deletePromotion->handle(
                new DeletePromotionCommand(
                    userId: $user->claims->userId,
                    promotionId: $promotionId,
                ),
            );

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'promotion/delete',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
