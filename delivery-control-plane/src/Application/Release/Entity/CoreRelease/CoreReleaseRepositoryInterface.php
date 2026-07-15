<?php

declare(strict_types=1);

namespace App\Application\Release\Entity\CoreRelease;

interface CoreReleaseRepositoryInterface
{
    public function save(CoreRelease $release): int;

    public function findLatest(): ?CoreRelease;

    public function clearLatestFlag(): void;
}

