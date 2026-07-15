<?php

declare(strict_types=1);

namespace App\Application\Customization\Contract;

use App\Application\Customization\Access\CustomRole;
use App\Shared\Enum\Feature\FeatureCodeEnum;

/**
 * Манифест клиентского модуля кастомизации — единственная точка, которую реализует код
 * из custom/src/{slug}. Реализации помечаются тегом app.custom_module (см. services.yaml)
 * и собираются CustomModuleRegistry.
 *
 * В single-tenant модели сервера все обнаруженные модули считаются активными. Ядро знает
 * про интерфейс, но никогда — про конкретных клиентов (инвариант «ядро не знает Custom»).
 *
 * slug() — стабильная идентичность (совпадает с папкой и префиксом таблиц custom_{slug}_*),
 * title() — свободно переименуемое отображение. previousSlugs() остаётся как машинный
 * список прежних идентификаторов для обратной совместимости данных/ключей.
 *
 * Удобнее наследовать AbstractCustomModule — он даёт разумные значения по умолчанию.
 */
interface CustomModuleInterface
{
    /** Стабильный идентификатор модуля, совпадает с папкой custom/src/{slug}. Не меняется. */
    public function slug(): string;

    /** Человекочитаемое название (для админки/логов). Можно менять свободно. */
    public function title(): string;

    /**
     * Прежние идентификаторы модуля (после переименования slug), если в данных/ключах
     * ещё встречаются старые значения.
     *
     * @return list<string>
     */
    public function previousSlugs(): array;

    /**
     * Возможности (фичи), которые модуль открывает воркспейсу. Учитываются FeatureGate
     * наравне с тарифом и точечными грантами.
     *
     * @return list<FeatureCodeEnum>
     */
    public function capabilities(): array;

    /**
     * Роли, которые модуль добавляет поверх Owner/Staff. Назначаются участникам воркспейса и
     * проверяются CustomAccess. Роль действует, только пока модуль присутствует в overlay сервера.
     *
     * @return list<CustomRole>
     */
    public function roles(): array;
}
