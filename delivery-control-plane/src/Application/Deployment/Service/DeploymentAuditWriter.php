<?php

declare(strict_types=1);

namespace App\Application\Deployment\Service;

use App\Application\Deployment\Entity\Deployment\Deployment;
use App\Application\Deployment\Entity\Deployment\DeploymentRepositoryInterface;

final class DeploymentAuditWriter
{
    public function __construct(
        private readonly DeploymentRepositoryInterface $deployments,
    ) {}

    public function record(
        string $kind,
        string $releaseRef,
        string $initiator,
        string $targetHost,
        string $status,
    ): void {
        $deployment = Deployment::buildNew(
            kind: $kind,
            releaseRef: $releaseRef,
            initiator: $initiator,
            targetHost: $targetHost,
            status: $status,
        );

        $this->deployments->save($deployment);
    }
}

