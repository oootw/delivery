<?php

declare(strict_types=1);

namespace App\Application\Tarif\Service;

use App\Application\Tarif\Entity\Tarif\TarifCodeEnum;

/**
 * Лимиты, которые тариф открывает владельцу.
 *
 * Сейчас все тарифы дают один воркспейс; дифференциация тарифов появится позже.
 * Когда у таблицы tarif появится собственная миграция, лимиты переедут в БД.
 */
final class TarifLimits
{
    private const DEFAULT_MAX_WORKSPACES = 1;

    public function maxWorkspaces(TarifCodeEnum $tarifCode): int
    {
        return match ($tarifCode) {
            TarifCodeEnum::BASIC,
            TarifCodeEnum::PRO,
            TarifCodeEnum::ENTERPRISE => self::DEFAULT_MAX_WORKSPACES,
        };
    }
}
