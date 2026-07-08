<?php

declare(strict_types=1);

namespace App\Infrastructure\Audit;

use App\Http\Security\JwtUser;
use App\Infrastructure\Doctrine\Domain\Audit\AuditRecord;
use App\Infrastructure\Doctrine\Domain\Menu\MenuItem;
use App\Infrastructure\Doctrine\Domain\Order\Order;
use App\Infrastructure\Doctrine\Domain\PosIntegration\PosConnection;
use App\Infrastructure\Doctrine\Domain\Subscription\Subscription;
use App\Infrastructure\Doctrine\Domain\Users\User;
use App\Infrastructure\Doctrine\Domain\Venue\Venue;
use App\Infrastructure\Doctrine\Domain\Workspace\Membership;
use App\Infrastructure\Doctrine\Domain\Workspace\Workspace;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Пишет историю изменений ключевых сущностей в audit_log. На onFlush снимает
 * набор изменений из UnitOfWork (там ещё доступны старые значения), на postFlush
 * — сохраняет записи (к этому моменту у новых сущностей уже есть id).
 *
 * Отслеживаются только бизнес-значимые сущности (WHITELIST); пароли и секреты
 * в лог не попадают (SENSITIVE_FIELDS).
 */
#[AsDoctrineListener(event: Events::onFlush)]
#[AsDoctrineListener(event: Events::postFlush)]
final class AuditSubscriber
{
    /** Сущность => человекочитаемое имя для действия в логе. */
    private const WHITELIST = [
        User::class => 'user',
        Subscription::class => 'subscription',
        Order::class => 'order',
        Workspace::class => 'workspace',
        Membership::class => 'membership',
        Venue::class => 'venue',
        PosConnection::class => 'pos_connection',
        MenuItem::class => 'menu_item',
    ];

    private const SENSITIVE_FIELDS = ['password', 'apiLoginEncrypted'];

    /** @var list<array{entity: object, action: string, type: string, changes: array<string, array{0: mixed, 1: mixed}>}> */
    private array $pending = [];

    public function __construct(
        private readonly Security $security,
    ) {}

    public function onFlush(OnFlushEventArgs $args): void
    {
        $unitOfWork = $args->getObjectManager()->getUnitOfWork();

        foreach ($unitOfWork->getScheduledEntityInsertions() as $entity) {
            $this->capture($entity, 'created', $unitOfWork->getEntityChangeSet($entity));
        }

        foreach ($unitOfWork->getScheduledEntityUpdates() as $entity) {
            $this->capture($entity, 'updated', $unitOfWork->getEntityChangeSet($entity));
        }

        foreach ($unitOfWork->getScheduledEntityDeletions() as $entity) {
            $this->capture($entity, 'deleted', []);
        }
    }

    public function postFlush(PostFlushEventArgs $args): void
    {
        if ($this->pending === []) {
            return;
        }

        $buffered = $this->pending;
        $this->pending = [];

        $entityManager = $args->getObjectManager();
        [$actorId, $actorLabel] = $this->actor();

        foreach ($buffered as $item) {
            $entityManager->persist(new AuditRecord(
                actorId: $actorId,
                actorLabel: $actorLabel,
                action: $item['type'] . '.' . $item['action'],
                entityType: $item['type'],
                entityId: $this->entityId($item['entity']),
                changes: $item['changes'],
            ));
        }

        $entityManager->flush();
    }

    /**
     * @param array<string, array{0: mixed, 1: mixed}> $changeSet
     */
    private function capture(object $entity, string $action, array $changeSet): void
    {
        $type = self::WHITELIST[$entity::class] ?? null;

        if ($type === null) {
            return;
        }

        $this->pending[] = [
            'entity' => $entity,
            'action' => $action,
            'type' => $type,
            'changes' => $this->readableChanges($changeSet),
        ];
    }

    /**
     * @param array<string, array{0: mixed, 1: mixed}> $changeSet
     * @return array<string, array{0: mixed, 1: mixed}>
     */
    private function readableChanges(array $changeSet): array
    {
        $changes = [];

        foreach ($changeSet as $field => [$old, $new]) {
            if (in_array($field, self::SENSITIVE_FIELDS, true)) {
                continue;
            }

            $changes[$field] = [$this->readableValue($old), $this->readableValue($new)];
        }

        return $changes;
    }

    private function readableValue(mixed $value): mixed
    {
        if ($value instanceof \BackedEnum) {
            return $value->value;
        }

        if ($value instanceof \DateTimeInterface) {
            return $value->format(\DateTimeInterface::ATOM);
        }

        if (is_scalar($value) || $value === null) {
            return $value;
        }

        return get_debug_type($value);
    }

    private function entityId(object $entity): ?int
    {
        if (method_exists($entity, 'getId')) {
            $id = $entity->getId();

            return is_int($id) ? $id : null;
        }

        return null;
    }

    /**
     * @return array{0: ?int, 1: string}
     */
    private function actor(): array
    {
        $user = $this->security->getUser();

        if ($user instanceof JwtUser) {
            return [$user->claims->userId, $user->claims->phone];
        }

        if ($user instanceof User) {
            return [$user->getId(), $user->getUserIdentifier()];
        }

        return [null, 'система'];
    }
}
