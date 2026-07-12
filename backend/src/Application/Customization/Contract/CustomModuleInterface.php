<?php

declare(strict_types=1);

namespace App\Application\Customization\Contract;

use App\Application\Customization\Access\CustomRole;
use App\Shared\Enum\Feature\FeatureCodeEnum;

/**
 * Манифест клиентского модуля кастомизации — единственная точка, которую реализует код
 * из src/Custom/{slug}. Реализации помечаются тегом app.custom_module (см. services.yaml)
 * и собираются CustomModuleRegistry.
 *
 * Наличие реализации НЕ активирует модуль: активность воркспейса определяется данными
 * (таблица workspace_custom_module), а не кодом. Ядро знает про интерфейс, но никогда — про
 * конкретных клиентов (см. backend/PLAN_CUSTOMIZATION.md, инвариант «ядро не знает Custom»).
 *
 * Устойчивость к переименованию: slug() — стабильная идентичность (совпадает с папкой и
 * префиксом таблиц custom_{slug}_*), title() — свободно переименуемое отображение. Если
 * идентичность всё же приходится сменить, старые значения объявляются в previousSlugs(), и
 * активации (workspace_custom_module) с прежним slug продолжают работать без миграции данных.
 *
 * Удобнее наследовать AbstractCustomModule — он даёт разумные значения по умолчанию.
 */
interface CustomModuleInterface
{
    /** Стабильный идентификатор модуля, совпадает с папкой src/Custom/{slug}. Не меняется. */
    public function slug(): string;

    /** Человекочитаемое название (для админки/логов). Можно менять свободно. */
    public function title(): string;

    /**
     * Прежние идентификаторы модуля (после переименования slug). По ним CustomModuleRegistry
     * тоже сопоставляет активации, чтобы кастомизация не «слетала».
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
     * проверяются CustomAccess. Роль действует, только пока модуль активен на воркспейсе.
     *
     * @return list<CustomRole>
     */
    public function roles(): array;
}
