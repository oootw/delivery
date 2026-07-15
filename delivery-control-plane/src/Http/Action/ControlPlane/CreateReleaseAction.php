<?php

declare(strict_types=1);

namespace App\Http\Action\ControlPlane;

use App\Application\Release\Command\RegisterRelease\RegisterReleaseCommand;
use App\Application\Release\Command\RegisterRelease\RegisterReleaseHandler;
use App\Http\Response\ApiResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CreateReleaseAction
{
    public function __construct(
        private readonly RegisterReleaseHandler $registerRelease,
        private readonly string $releaseWriteToken = '',
    ) {}

    #[Route('/v1/release', name: 'cp_create_release', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        if (!$this->authorized($request)) {
            return ApiResponse::error('Недостаточно прав для регистрации релиза', Response::HTTP_UNAUTHORIZED);
        }

        try {
            $payload = $request->toArray();

            $release = $this->registerRelease->handle(new RegisterReleaseCommand(
                ref: trim((string) ($payload['ref'] ?? '')),
                contractVersion: trim((string) ($payload['contract_version'] ?? '')),
            ));

            return ApiResponse::success([
                'ref' => $release->ref,
                'contract_version' => $release->contractVersion,
                'latest' => $release->isLatest,
            ], Response::HTTP_CREATED);
        } catch (\DomainException $exception) {
            return ApiResponse::error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Throwable) {
            return ApiResponse::error('Не удалось зарегистрировать релиз', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function authorized(Request $request): bool
    {
        if ($this->releaseWriteToken === '') {
            return true;
        }

        $header = trim((string) $request->headers->get('Authorization', ''));
        if (!str_starts_with($header, 'Bearer ')) {
            return false;
        }

        return hash_equals($this->releaseWriteToken, trim(substr($header, 7)));
    }
}

