<?php

declare(strict_types=1);

namespace App\Infrastructure\Metrics;

use App\Shared\Service\LoggerService\LoggerService;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpKernel\Event\TerminateEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * Считает прикладную нагрузку: на каждый обработанный запрос увеличивает счётчик
 * в поминутной корзине request_metric (плюс отдельно ошибки 5xx). Работает на
 * kernel.terminate — уже после отправки ответа, поэтому не влияет на его скорость.
 * Служебные запросы профайлера (/_...) не считаем.
 */
#[AsEventListener(event: KernelEvents::TERMINATE)]
final class RequestMetricListener
{
    public function __construct(
        private readonly Connection $connection,
    ) {}

    public function __invoke(TerminateEvent $event): void
    {
        if (str_starts_with($event->getRequest()->getPathInfo(), '/_')) {
            return;
        }

        $isError = $event->getResponse()->getStatusCode() >= 500 ? 1 : 0;
        $minuteBucket = (new \DateTimeImmutable())->format('Y-m-d H:i:00');

        try {
            $this->connection->executeStatement(
                'INSERT INTO request_metric (minute_bucket, requests, errors) VALUES (:bucket, 1, :errors)
                 ON CONFLICT (minute_bucket)
                 DO UPDATE SET requests = request_metric.requests + 1, errors = request_metric.errors + :errors',
                ['bucket' => $minuteBucket, 'errors' => $isError],
            );
        } catch (\Throwable $exception) {
            LoggerService::toFile(
                fileName: 'metrics/request-counter',
                message: $exception->getMessage(),
            );
        }
    }
}
