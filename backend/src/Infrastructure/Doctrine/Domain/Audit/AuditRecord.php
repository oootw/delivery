<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Audit;

use Doctrine\ORM\Mapping as ORM;

/**
 * Запись аудита — след ключевого бизнес-события в системе: кто, что, когда и что
 * именно изменилось. Пишется автоматически подписчиком AuditSubscriber при
 * изменении отслеживаемых сущностей. Только на чтение в админке.
 */
#[ORM\Entity]
#[ORM\Table(name: 'audit_log')]
#[ORM\Index(name: 'idx_audit_created', columns: ['created_at'])]
#[ORM\Index(name: 'idx_audit_entity', columns: ['entity_type', 'entity_id'])]
#[ORM\Index(name: 'idx_audit_actor', columns: ['actor_id'])]
class AuditRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $actorId = null;

    /** Человекочитаемый актор: телефон пользователя, либо «система»/«webhook». */
    #[ORM\Column(length: 255)]
    private string $actorLabel;

    /** Действие вида «order.updated», «subscription.created». */
    #[ORM\Column(length: 100)]
    private string $action;

    #[ORM\Column(length: 100)]
    private string $entityType;

    #[ORM\Column(nullable: true)]
    private ?int $entityId = null;

    /** @var array<string, array{0: mixed, 1: mixed}> изменённые поля: имя => [было, стало] */
    #[ORM\Column(type: 'json')]
    private array $changes = [];

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    /**
     * @param array<string, array{0: mixed, 1: mixed}> $changes
     */
    public function __construct(
        ?int $actorId,
        string $actorLabel,
        string $action,
        string $entityType,
        ?int $entityId,
        array $changes,
    ) {
        $this->actorId = $actorId;
        $this->actorLabel = $actorLabel;
        $this->action = $action;
        $this->entityType = $entityType;
        $this->entityId = $entityId;
        $this->changes = $changes;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActorId(): ?int
    {
        return $this->actorId;
    }

    public function getActorLabel(): string
    {
        return $this->actorLabel;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getEntityType(): string
    {
        return $this->entityType;
    }

    public function getEntityId(): ?int
    {
        return $this->entityId;
    }

    /**
     * @return array<string, array{0: mixed, 1: mixed}>
     */
    public function getChanges(): array
    {
        return $this->changes;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
