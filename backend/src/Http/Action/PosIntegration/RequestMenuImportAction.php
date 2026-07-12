<?php

declare(strict_types=1);

namespace App\Http\Action\PosIntegration;

use App\Application\PosIntegration\Command\RequestMenuImport\RequestMenuImportCommand;
use App\Application\PosIntegration\Command\RequestMenuImport\RequestMenuImportHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RequestMenuImportAction extends AbstractController
{
    public function __construct(
        private readonly RequestMenuImportHandler $requestMenuImport,
    ) {}

    #[Route('/venues/{venueId}/pos/import', name: 'app_request_menu_import', methods: ['POST'], requirements: ['venueId' => '\d+'])]
    public function handle(int $venueId): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->requestMenuImport->handle(
                new RequestMenuImportCommand(
                    ownerId: $user->claims->userId,
                    venueId: $venueId,
                ),
            );

            return ApiResponse::success(['status' => 'queued'], Response::HTTP_ACCEPTED);
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'pos/request-import',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
