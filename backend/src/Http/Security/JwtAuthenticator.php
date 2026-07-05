<?php

declare(strict_types=1);

namespace App\Http\Security;

use App\Shared\Service\JWTManager\JWTManager;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class JwtAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{
    public function __construct(
        private readonly JWTManager $jwtManager,
    ) {}

    public function supports(Request $request): ?bool
    {
        return true;
    }

    public function authenticate(Request $request): Passport
    {
        $token = $this->extractBearerToken($request->headers->get('Authorization'));

        try {
            $claims = $this->jwtManager->validateAccessToken($token);
        } catch (InvalidArgumentException $exception) {
            throw new CustomUserMessageAuthenticationException($exception->getMessage());
        }

        return new SelfValidatingPassport(
            new UserBadge((string) $claims->userId, fn(): JwtUser => new JwtUser($claims)),
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        return $this->createErrorResponse($exception->getMessage());
    }

    public function start(Request $request, ?AuthenticationException $authException = null): Response
    {
        return $this->createErrorResponse(
            $authException?->getMessage() ?? 'Обязателен заголовок Authorization',
        );
    }

    private function extractBearerToken(?string $authorization): string
    {
        if ($authorization === null || $authorization === '') {
            throw new CustomUserMessageAuthenticationException('Обязателен заголовок Authorization');
        }

        if (!preg_match('/^Bearer\s(\S+)$/i', $authorization, $matches)) {
            throw new CustomUserMessageAuthenticationException('Неверный формат заголовка Authorization');
        }

        return $matches[1];
    }

    private function createErrorResponse(string $error): JsonResponse
    {
        return new JsonResponse(
            [
                'is_success' => false,
                'error' => $error,
            ],
            Response::HTTP_UNAUTHORIZED,
        );
    }
}
