<?php

declare(strict_types=1);

namespace App\Application\Deployment\Entity\Deployment;

interface DeploymentRepositoryInterface
{
    public function save(Deployment $deployment): int;
}

