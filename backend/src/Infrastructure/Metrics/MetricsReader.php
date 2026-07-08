<?php

declare(strict_types=1);

namespace App\Infrastructure\Metrics;

use Doctrine\DBAL\Connection;

/**
 * Собирает снимок прикладных метрик для дашборда админки: заказы, подписки,
 * очередь Messenger, объёмы данных, нагрузку по минутам и отклик БД.
 *
 * Каждая выборка защищена от отсутствующей таблицы (например, messenger_messages
 * создаётся лениво) — дашборд не должен падать из-за одной метрики.
 */
final class MetricsReader
{
    private const REQUEST_WINDOW_MINUTES = 60;

    public function __construct(
        private readonly Connection $connection,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function snapshot(): array
    {
        return [
            'orders' => [
                'by_status' => $this->countGroupedByStatus('"order"'),
                'today' => $this->countToday('"order"'),
                'active' => $this->countActiveOrders(),
            ],
            'subscriptions' => [
                'by_status' => $this->countGroupedByStatus('subscription'),
            ],
            'queue' => [
                'pending' => $this->countMessengerQueue('default'),
                'failed' => $this->countMessengerQueue('failed'),
            ],
            'totals' => [
                'users' => $this->countRows('"user"'),
                'workspaces' => $this->countRows('workspace'),
                'venues' => $this->countRows('venue'),
            ],
            'requests' => $this->requestSeries(),
            'db_ping_ms' => $this->databasePingMs(),
        ];
    }

    /**
     * @return array<string, int>
     */
    private function countGroupedByStatus(string $table): array
    {
        return $this->guard(function () use ($table): array {
            $rows = $this->connection->fetchAllAssociative(
                sprintf('SELECT status, COUNT(*) AS total FROM %s GROUP BY status', $table),
            );

            $result = [];

            foreach ($rows as $row) {
                $result[(string) $row['status']] = (int) $row['total'];
            }

            return $result;
        }, []);
    }

    private function countToday(string $table): int
    {
        return $this->guard(fn(): int => (int) $this->connection->fetchOne(
            sprintf('SELECT COUNT(*) FROM %s WHERE created_at >= :today', $table),
            ['today' => (new \DateTimeImmutable('today'))->format('Y-m-d H:i:s')],
        ), 0);
    }

    private function countActiveOrders(): int
    {
        return $this->guard(fn(): int => (int) $this->connection->fetchOne(
            'SELECT COUNT(*) FROM "order" WHERE status IN (:statuses)',
            ['statuses' => ['paid', 'accepted', 'cooking', 'ready', 'on_the_way']],
            ['statuses' => \Doctrine\DBAL\ArrayParameterType::STRING],
        ), 0);
    }

    private function countMessengerQueue(string $queueName): int
    {
        return $this->guard(fn(): int => (int) $this->connection->fetchOne(
            'SELECT COUNT(*) FROM messenger_messages WHERE queue_name = :queue',
            ['queue' => $queueName],
        ), 0);
    }

    private function countRows(string $table): int
    {
        return $this->guard(fn(): int => (int) $this->connection->fetchOne(
            sprintf('SELECT COUNT(*) FROM %s', $table),
        ), 0);
    }

    /**
     * @return array<int, array{minute: string, requests: int, errors: int}>
     */
    private function requestSeries(): array
    {
        return $this->guard(function (): array {
            $since = (new \DateTimeImmutable(sprintf('-%d minutes', self::REQUEST_WINDOW_MINUTES)))->format('Y-m-d H:i:00');

            $rows = $this->connection->fetchAllAssociative(
                'SELECT minute_bucket, requests, errors FROM request_metric WHERE minute_bucket >= :since ORDER BY minute_bucket',
                ['since' => $since],
            );

            return array_map(static fn(array $row): array => [
                'minute' => (new \DateTimeImmutable((string) $row['minute_bucket']))->format('H:i'),
                'requests' => (int) $row['requests'],
                'errors' => (int) $row['errors'],
            ], $rows);
        }, []);
    }

    private function databasePingMs(): float
    {
        return $this->guard(function (): float {
            $startedAt = microtime(true);
            $this->connection->executeQuery('SELECT 1');

            return round((microtime(true) - $startedAt) * 1000, 2);
        }, 0.0);
    }

    /**
     * @template T
     * @param callable(): T $query
     * @param T $fallback
     * @return T
     */
    private function guard(callable $query, mixed $fallback): mixed
    {
        try {
            return $query();
        } catch (\Throwable) {
            return $fallback;
        }
    }
}
