<?php

declare(strict_types=1);

namespace App\Http\Workspace;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Определяет текущий воркспейс по входящему запросу и кладёт его slug в WorkspaceContext.
 *
 * Основной путь — поддомен вида slug.app.com.
 * В dev дополнительно разрешён заголовок X-Workspace-Slug, чтобы тестировать без поддоменов.
 */
#[AsEventListener(event: KernelEvents::REQUEST, priority: 16)]
final class WorkspaceContextListener
{
    private const DEV_SLUG_HEADER = 'X-Workspace-Slug';

    public function __construct(
        private readonly WorkspaceContext $workspaceContext,
        private readonly string $rootDomain,
        private readonly bool $devHeaderAllowed,
    ) {}

    public function __invoke(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        $slug = $this->readSlugFromHost($request->getHost());

        if ($slug === null && $this->devHeaderAllowed) {
            $slug = $request->headers->get(self::DEV_SLUG_HEADER) ?: null;
        }

        if ($slug !== null) {
            $this->workspaceContext->bindSlug($slug);
        }
    }

    private function readSlugFromHost(string $host): ?string
    {
        $rootSuffix = '.' . $this->rootDomain;

        if (!str_ends_with($host, $rootSuffix)) {
            return null;
        }

        $subdomain = substr($host, 0, -strlen($rootSuffix));

        if ($subdomain === '' || $subdomain === 'www') {
            return null;
        }

        return $subdomain;
    }
}
