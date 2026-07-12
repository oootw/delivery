<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Billing;

use App\Application\Billing\Entity\WorkspacePaymentSettings\WorkspacePaymentSettings as WorkspacePaymentSettingsEntity;
use App\Application\Billing\Entity\WorkspacePaymentSettings\WorkspacePaymentSettingsRepositoryInterface;
use App\Shared\Service\Crypto\SecretCipher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkspacePaymentSettings>
 */
class WorkspacePaymentSettingsRepository extends ServiceEntityRepository implements WorkspacePaymentSettingsRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly SecretCipher $secretCipher,
    ) {
        parent::__construct($registry, WorkspacePaymentSettings::class);
    }

    public function findByWorkspace(int $workspaceId): ?WorkspacePaymentSettingsEntity
    {
        $record = $this->findOneBy(['workspaceId' => $workspaceId]);

        return $record !== null ? $this->toEntity($record) : null;
    }

    public function save(WorkspacePaymentSettingsEntity $settings): int
    {
        $record = $settings->id !== null
            ? $this->find($settings->id)
            : new WorkspacePaymentSettings();

        if ($record === null) {
            throw new \DomainException('Настройка оплаты не найдена');
        }

        $record->setWorkspaceId($settings->workspaceId);
        $record->setProvider($settings->provider);
        $record->setCredentialsEncrypted(
            $this->secretCipher->encrypt(json_encode($settings->credentials, JSON_THROW_ON_ERROR)),
        );
        $record->setIsActive($settings->isActive);
        $record->setCreatedAt($settings->createdAt);
        $record->setUpdatedAt($settings->updatedAt);

        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $settings->assignId($record->getId());

        return $record->getId();
    }

    private function toEntity(WorkspacePaymentSettings $record): WorkspacePaymentSettingsEntity
    {
        /** @var array<string, string> $credentials */
        $credentials = json_decode(
            $this->secretCipher->decrypt($record->getCredentialsEncrypted()),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );

        return new WorkspacePaymentSettingsEntity(
            id: $record->getId(),
            workspaceId: $record->getWorkspaceId(),
            provider: $record->getProvider(),
            credentials: $credentials,
            isActive: $record->isActive(),
            createdAt: $record->getCreatedAt(),
            updatedAt: $record->getUpdatedAt(),
        );
    }
}
