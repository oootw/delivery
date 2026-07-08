<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Workspace;

use App\Application\Workspace\Entity\Workspace\Workspace as WorkspaceEntity;
use App\Application\Workspace\Entity\Workspace\WorkspaceRepositoryInterface;
use App\Shared\VO\Image\ImageValueObject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Workspace>
 */
class WorkspaceRepository extends ServiceEntityRepository implements WorkspaceRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Workspace::class);
    }

    public function save(WorkspaceEntity $workspace): int
    {
        $record = $workspace->id !== null
            ? $this->find($workspace->id)
            : new Workspace();

        if ($record === null) {
            throw new \DomainException('Воркспейс не найден');
        }

        $record->setName($workspace->name);
        $record->setSlug($workspace->slug);
        $record->setDescription($workspace->description);
        $record->setLogo($this->logoToArray($workspace->logo));
        $record->setOwnerId($workspace->ownerId);
        $record->setCreatedAt($workspace->createdAt);
        $record->setUpdatedAt($workspace->updatedAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $workspace->assignId($record->getId());

        return $record->getId();
    }

    public function findById(int $id): ?WorkspaceEntity
    {
        $record = $this->find($id);

        return $record !== null ? $this->toEntity($record) : null;
    }

    public function findBySlug(string $slug): ?WorkspaceEntity
    {
        $record = $this->findOneBy(['slug' => $slug]);

        return $record !== null ? $this->toEntity($record) : null;
    }

    /**
     * @param int[] $ids
     * @return WorkspaceEntity[]
     */
    public function findAllByIds(array $ids): array
    {
        if ($ids === []) {
            return [];
        }

        return array_map(
            fn(Workspace $record): WorkspaceEntity => $this->toEntity($record),
            $this->findBy(['id' => $ids]),
        );
    }

    public function countByOwner(int $ownerId): int
    {
        return $this->count(['ownerId' => $ownerId]);
    }

    private function toEntity(Workspace $record): WorkspaceEntity
    {
        return new WorkspaceEntity(
            id: $record->getId(),
            name: $record->getName(),
            slug: $record->getSlug(),
            description: $record->getDescription(),
            logo: $this->logoFromArray($record->getLogo()),
            ownerId: $record->getOwnerId(),
            createdAt: $record->getCreatedAt(),
            updatedAt: $record->getUpdatedAt(),
        );
    }

    /** @param array<string, string>|null $logo */
    private function logoFromArray(?array $logo): ?ImageValueObject
    {
        if ($logo === null) {
            return null;
        }

        return new ImageValueObject(
            path: $logo['path'],
            title: $logo['title'],
            description: $logo['description'],
            width: $logo['width'],
            height: $logo['height'],
            size: $logo['size'],
            extension: $logo['extension'],
        );
    }

    /** @return array<string, string>|null */
    private function logoToArray(?ImageValueObject $logo): ?array
    {
        if ($logo === null) {
            return null;
        }

        return [
            'path' => $logo->path,
            'title' => $logo->title,
            'description' => $logo->description,
            'width' => $logo->width,
            'height' => $logo->height,
            'size' => $logo->size,
            'extension' => $logo->extension,
        ];
    }
}
