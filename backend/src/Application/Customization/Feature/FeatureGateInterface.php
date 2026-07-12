<?php

declare(strict_types=1);

namespace App\Application\Customization\Feature;

use App\Shared\Enum\Feature\FeatureCodeEnum;

/**
 * Единый гейт возможностей воркспейса. Объединяет три источника: тариф владельца, активные
 * клиентские модули и точечные гранты. Всё ключуется на числовой workspace_id — переименование
 * slug воркспейса или модуля на доступ не влияет.
 */
interface FeatureGateInterface
{
    public function has(int $workspaceId, FeatureCodeEnum $feature): bool;

    /**
     * Все включённые на воркспейсе фичи (объединение источников, без дублей).
     *
     * @return list<FeatureCodeEnum>
     */
    public function enabledFor(int $workspaceId): array;
}
