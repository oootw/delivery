<?php

declare(strict_types=1);

namespace App\Http\Action\Loyalty;

use App\Application\Loyalty\Command\SetStampProgram\Command as SetStampProgramCommand;
use App\Application\Loyalty\Command\SetStampProgram\Handler as SetStampProgramHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class SetStampProgramAction extends AbstractController
{
    public function __construct(
        private readonly SetStampProgramHandler $setStampProgram,
    ) {}

    #[Route('/workspaces/{workspaceId}/loyalty/stamp-program', name: 'app_set_stamp_program', methods: ['PUT'], requirements: ['workspaceId' => '\d+'])]
    public function handle(Request $request, int $workspaceId): Response
    {
        try {
            $body = $request->toArray();

            $requiredCount = $body['required_count'] ?? null;
            $rewardPoints = $body['reward_points'] ?? null;

            Assert::integer($requiredCount, 'Укажите число штампов для награды');
            Assert::integer($rewardPoints, 'Укажите награду в баллах');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->setStampProgram->handle(
                new SetStampProgramCommand(
                    ownerId: $user->claims->userId,
                    workspaceId: $workspaceId,
                    isEnabled: $body['is_enabled'] ?? false,
                    requiredCount: $requiredCount,
                    rewardPoints: $rewardPoints,
                ),
            );

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'loyalty/set-stamp-program',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
