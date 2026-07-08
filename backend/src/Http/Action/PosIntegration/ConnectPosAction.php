<?php

declare(strict_types=1);

namespace App\Http\Action\PosIntegration;

use App\Application\PosIntegration\Command\ConnectPos\Command as ConnectPosCommand;
use App\Application\PosIntegration\Command\ConnectPos\Handler as ConnectPosHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class ConnectPosAction extends AbstractController
{
    public function __construct(
        private readonly ConnectPosHandler $connectPos,
    ) {}

    #[Route('/venues/{venueId}/pos', name: 'app_connect_pos', methods: ['POST'], requirements: ['venueId' => '\d+'])]
    public function handle(Request $request, int $venueId): Response
    {
        try {
            $body = $request->toArray();

            $posSystem = $body['pos_system'] ?? null;
            $apiLogin = $body['api_login'] ?? null;
            $organizationId = $body['organization_id'] ?? null;
            $externalMenuId = $body['external_menu_id'] ?? null;

            Assert::notEmpty($posSystem, 'Укажите POS-систему');
            Assert::notEmpty($apiLogin, 'Укажите apiLogin');
            Assert::notEmpty($organizationId, 'Укажите идентификатор организации');
            Assert::notEmpty($externalMenuId, 'Укажите идентификатор внешнего меню');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $connectionId = $this->connectPos->handle(
                new ConnectPosCommand(
                    ownerId: $user->claims->userId,
                    venueId: $venueId,
                    posSystem: $posSystem,
                    apiLogin: $apiLogin,
                    organizationId: $organizationId,
                    externalMenuId: $externalMenuId,
                ),
            );

            return ApiResponse::success(['connection_id' => $connectionId]);
        } catch (InvalidArgumentException | \DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'pos/connect',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
