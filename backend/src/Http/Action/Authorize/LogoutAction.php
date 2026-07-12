<?php

declare(strict_types=1);

namespace App\Http\Action\Authorize;

use App\Application\Authorize\Command\Logout\LogoutCommand;
use App\Application\Authorize\Command\Logout\LogoutHandler;
use App\Application\Authorize\Query\FindUserByPhone\FindUserByPhoneFetcher;
use App\Application\Authorize\Query\FindUserByPhone\FindUserByPhoneQuery;
use App\Http\Response\ApiResponse;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class LogoutAction extends AbstractController
{
    public function __construct(
        private readonly LogoutHandler $logout,
        private readonly FindUserByPhoneFetcher $findUserByPhone,
    ) {}

    #[Route('/logout', name: 'app_logout', methods: ['POST'])]
    public function handle(Request $request): Response
    {
        try {
            $body = $request->toArray();

            $phone = $body['phone'] ?? null;

            Assert::notEmpty($phone, 'Укажите номер телефона');

            $user = $this->findUserByPhone->fetch(
                new FindUserByPhoneQuery(phone: $phone),
            );

            if ($user !== null) {
                $this->logout->handle(
                    new LogoutCommand(userId: $user->id),
                );
            }

            return ApiResponse::success();
        } catch (InvalidArgumentException $exception) {
            return ApiResponse::error($exception->getMessage());
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'auth/logout',
                message: $exception->getMessage(),
            );

            return ApiResponse::error(
                error: 'Что-то пошло не так',
                status: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
