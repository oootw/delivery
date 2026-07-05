<?php

declare(strict_types=1);

namespace App\Http\Action\Authorize;

use App\Application\Authorize\Command\CreateAuthorizeCode\Command;
use App\Application\Authorize\Command\CreateAuthorizeCode\Handler;
use App\Application\Authorize\Entity\Code\CodeTypeEnum;
use App\Application\Authorize\Query\FindUserByPhone\Fetcher;
use App\Application\Authorize\Query\GetSmsCode\Fetcher as GetSmsCodeFetcher;
use App\Application\Authorize\Query\GetSmsCodeSendAvailable\Fetcher as GetSmsCodeSendAvailableFetcher;
use App\Shared\Service\LoggerService\LoggerService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class GetAuthCodeAction extends AbstractController
{
    public function __construct(
        private readonly Fetcher $findUserByPhone,
        private readonly GetSmsCodeSendAvailableFetcher $getSmsCodeSendAvailable,
        private readonly Handler $createAuthorizeCode,
        private readonly GetSmsCodeFetcher $getSmsCode,
    ) {}

    #[Route('/get-auth-code', name: 'app_get_auth_code', methods: ['POST'])]
    public function handle(Request $request): Response
    {
        try {
            $body = $request->toArray();

            $phone = $body['phone'] ?? null;
            $codeType = $body['codeType'] ?? null;

            Assert::notEmpty($phone, 'Укажите номер телефона');
            Assert::notEmpty($codeType, 'Укажите тип кода');
            Assert::eq($codeType, CodeTypeEnum::Register->value, 'Недопустимый тип кода');

            $user = $this->findUserByPhone->fetch(
                new \App\Application\Authorize\Query\FindUserByPhone\Query(
                    phone: $phone,
                )
            );

            Assert::notNull($user, 'Пользователь не найден');

            $isCodeSendAvailable = $this->getSmsCodeSendAvailable->fetch(
                new \App\Application\Authorize\Query\GetSmsCodeSendAvailable\Query(
                    phone: $phone,
                )
            );

            Assert::true($isCodeSendAvailable, 'Код уже отправлен');

            $authorizeCode = $this->createAuthorizeCode->handle(
                new Command(
                    phone: $phone,
                    codeType: $codeType,
                )
            );

            $this->getSmsCode->fetch(
                new \App\Application\Authorize\Query\GetSmsCode\Query(
                    phone: $phone,
                    message: 'Ваш код для авторизации: ' . $authorizeCode->code,
                )
            );

            return $this->json([
                'is_success' => true,
            ]);
        } catch (InvalidArgumentException $exception) {

            return $this->json([
                'is_success' => false,
                'error' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'auth/get-auth-code',
                message: $exception->getMessage()
            );

            return $this->json([
                'is_success' => false,
                'error' => 'Что-то пошло не так',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
