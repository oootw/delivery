<?php

declare(strict_types=1);

namespace App\Console\Command;

use App\Application\Tarif\Entity\Tarif\Tarif;
use App\Application\Tarif\Entity\Tarif\TarifRepositoryInterface;
use Delivery\Contracts\Enum\TarifCodeEnum;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:cp:seed-tarifs',
    description: 'Заполнить справочник тарифов в control-plane',
)]
final class SeedTarifsCommand extends Command
{
    public function __construct(
        private readonly TarifRepositoryInterface $tarifs,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $seed = [
            [TarifCodeEnum::BASIC, 'Basic', 'Базовый тариф', 2900],
            [TarifCodeEnum::PRO, 'Pro', 'Тариф для растущих владельцев', 9900],
            [TarifCodeEnum::ENTERPRISE, 'Enterprise', 'Расширенный тариф для сетей', 29900],
        ];

        foreach ($seed as [$code, $name, $description, $price]) {
            $existing = $this->tarifs->findByCode($code);
            if ($existing !== null) {
                continue;
            }

            $tarif = Tarif::buildNew(
                code: $code,
                name: $name,
                description: $description,
                price: $price,
            );
            $this->tarifs->save($tarif);
        }

        $io->success('Справочник тарифов заполнен');

        return self::SUCCESS;
    }
}

