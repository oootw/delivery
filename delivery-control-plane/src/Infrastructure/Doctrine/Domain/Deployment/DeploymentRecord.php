<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Domain\Deployment;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'cp_deployment')]
class DeploymentRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private string $kind;

    #[ORM\Column(length: 128)]
    private string $releaseRef;

    #[ORM\Column(length: 128)]
    private string $initiator;

    #[ORM\Column(length: 190)]
    private string $targetHost;

    #[ORM\Column(length: 32)]
    private string $status;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKind(): string
    {
        return $this->kind;
    }

    public function setKind(string $kind): void
    {
        $this->kind = $kind;
    }

    public function getReleaseRef(): string
    {
        return $this->releaseRef;
    }

    public function setReleaseRef(string $releaseRef): void
    {
        $this->releaseRef = $releaseRef;
    }

    public function getInitiator(): string
    {
        return $this->initiator;
    }

    public function setInitiator(string $initiator): void
    {
        $this->initiator = $initiator;
    }

    public function getTargetHost(): string
    {
        return $this->targetHost;
    }

    public function setTargetHost(string $targetHost): void
    {
        $this->targetHost = $targetHost;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}

