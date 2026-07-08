<?php

declare(strict_types=1);

namespace App\Application\PosIntegration\Gateway;

use App\Application\PosIntegration\Entity\PosConnection\PosSystemEnum;

/**
 * Выбирает провайдера меню под конкретную POS-систему.
 * Провайдеры регистрируются как реализации PosMenuProviderInterface.
 */
final class PosMenuProviderRegistry
{
    /**
     * @param iterable<PosMenuProviderInterface> $providers
     */
    public function __construct(
        private readonly iterable $providers,
    ) {}

    public function providerFor(PosSystemEnum $posSystem): PosMenuProviderInterface
    {
        foreach ($this->providers as $provider) {
            if ($provider->supports($posSystem)) {
                return $provider;
            }
        }

        throw new \DomainException('Нет интеграции для POS-системы ' . $posSystem->value);
    }
}
