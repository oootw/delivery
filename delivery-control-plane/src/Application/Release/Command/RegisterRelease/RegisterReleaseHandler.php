<?php

declare(strict_types=1);

namespace App\Application\Release\Command\RegisterRelease;

use App\Application\Release\Entity\CoreRelease\CoreRelease;
use App\Application\Release\Entity\CoreRelease\CoreReleaseRepositoryInterface;

final class RegisterReleaseHandler
{
    public function __construct(
        private readonly CoreReleaseRepositoryInterface $releases,
    ) {}

    public function handle(RegisterReleaseCommand $command): CoreRelease
    {
        if ($command->ref === '') {
            throw new \DomainException('ref не может быть пустым');
        }

        if ($command->contractVersion === '') {
            throw new \DomainException('contract_version не может быть пустым');
        }

        $this->releases->clearLatestFlag();

        $release = CoreRelease::buildNew(
            ref: $command->ref,
            contractVersion: $command->contractVersion,
        );
        $this->releases->save($release);

        return $release;
    }
}

