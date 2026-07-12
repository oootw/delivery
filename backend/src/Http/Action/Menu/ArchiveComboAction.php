<?php

declare(strict_types=1);

namespace App\Http\Action\Menu;

use App\Application\Menu\Command\ArchiveCombo\ArchiveComboCommand;
use App\Application\Menu\Command\ArchiveCombo\ArchiveComboHandler;
use App\Http\Response\ApiResponse;
use App\Http\Security\JwtUser;
use App\Shared\Service\LoggerService\LoggerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArchiveComboAction extends AbstractController
{
    public function __construct(
        private readonly ArchiveComboHandler $archiveCombo,
    ) {}

    #[Route('/combos/{comboId}', name: 'app_archive_combo', methods: ['DELETE'], requirements: ['comboId' => '\d+'])]
    public function handle(int $comboId): Response
    {
        try {
            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->archiveCombo->handle(
                new ArchiveComboCommand(
                    userId: $user->claims->userId,
                    comboId: $comboId,
                ),
            );

            return ApiResponse::success();
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'menu/combo-archive',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
