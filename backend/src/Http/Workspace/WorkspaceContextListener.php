<?php

declare(strict_types=1);

namespace App\Http\Workspace;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Фиксирует текущий воркспейс из конфигурации сервера (WORKSPACE_ID) в контексте запроса.
 */
#[AsEventListener(event: KernelEvents::REQUEST, priority: 16)]
final class WorkspaceContextListener
{
    public function __construct(
        private readonly WorkspaceContext $workspaceContext,
        private readonly int $workspaceId,
    ) {}

    public function __invoke(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }
        $this->workspaceContext->bindWorkspaceId($this->workspaceId);
    }
}
