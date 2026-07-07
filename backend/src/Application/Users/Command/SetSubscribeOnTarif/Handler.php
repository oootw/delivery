<?php

declare(strict_types=1);

namespace App\Application\Users\Command\SetSubscribeOnTarif;

use App\Application\Tarif\Entity\Tarif\TarifCodeEnum;
use App\Application\Tarif\Entity\Tarif\TarifRepositoryInterface;
use App\Application\Users\Entity\User\UserRepositoryInterface;

class Handler
{
    public function __construct(
        private readonly TarifRepositoryInterface $tarifs,
        private readonly UserRepositoryInterface $users,
    ) {}

    public function handle(Command $command): void
    {
        $tarif = $this->tarifs->getByTarifCode(
            TarifCodeEnum::from($command->tarifCode)
        );

        if (!$tarif) {
            throw new \DomainException('Тариф не найден');
        }

        $user = $this->users->findById($command->userId);

        if (!$user) {
            throw new \DomainException('Пользователь не найден');
        }


    }
}
