# Система кастомизации — гайд для холодной сессии (2026-07-12)

Самодостаточный справочник по слою кастомизации: что это, где лежит, как расширять, что
проверить, чего не сломать. Проектное решение и обоснование — в `backend/PLAN_CUSTOMIZATION.md`
(ADR). Этот файл — операционный: рецепты + карта + подводные камни.

## 1. Зачем это

Ядро продаётся по подписке. Доработки — двух видов: **глобальные** (едут всем) и **локальные
платные** (под конкретного владельца/воркспейс, вплоть до своих ролей и разделов админки).
Задача слоя — чтобы глобальные обновления не ломали клиентский кастом, а кастом добавлялся/
снимался без правки ядра.

**Главный инвариант (нарушать нельзя):**
> Ядро (`App\Application`, `App\Infrastructure`, `App\Http`) **никогда** не импортирует
> `App\Custom\*` и не содержит `if ($workspaceId === N)`. Кастом — либо данные, либо реализация
> за стабильным интерфейсом, выбираемая по воркспейсу через реестр/резолвер. Ядро не знает имён
> клиентов. Проверяет тест `tests/Unit/Architecture/CustomizationBoundaryTest`.

Всё ключуется на **числовой `workspace_id`** → переименование slug воркспейса/модуля не рушит
кастомизацию (см. §7).

## 2. Статус (что готово)

| Срез | Что | Статус |
|------|-----|--------|
| 0 | Каркас модулей: манифест, реестр, активация данными | ✅ |
| 1 | Configure: типизированные настройки воркспейса | ✅ |
| 2 | Capabilities: `FeatureGate` (тариф ∪ модули ∪ гранты) | ✅ |
| 3 | Extend: роутинг Custom, роли, админ-разделы, пилот `Acme` | ✅ |
| 4 | Replace: `TenantStrategyResolver` (обобщить платёжную фабрику) | ⬜ не начат |
| 5 | DevX: `app:custom:new` скаффолдер, `app:custom:doctor` | ⬜ не начат |

**Тесты:** `tests/Unit/Customization/*` + `tests/Unit/Architecture/CustomizationBoundaryTest`.
Прогон: `php bin/phpunit` → должно быть зелёно (на 2026-07-12: 83/83).

**⚠️ Миграции ещё НЕ применены к БД.** Проверялось статикой (`lint:container`,
`doctrine:schema:validate --skip-sync`, регистрация роутов) и unit-тестами. Перед прогоном
против БД: `php bin/console doctrine:migrations:migrate`.

## 3. Три режима кастомизации (выбирай самый нижний)

| Режим | Когда | Куда смотреть |
|-------|-------|----------------|
| **Configure** | поменять данные/параметр | §5.1 Настройки |
| **Extend** | добавить новое (эндпоинт, сущность, роль, админку) | §5.3 Новый модуль |
| **Replace** | подменить стратегию ядра по воркспейсу | Срез 4 (не готов) |

## 4. Карта кода

### Каркас (ядро, `src/Application/Customization/`)
```
Contract/CustomModuleInterface   манифест модуля: slug/title/previousSlugs/capabilities/roles
Contract/AbstractCustomModule    база с дефолтами (наследуй в модулях)
Registry/CustomModuleRegistry    сбор модулей (тег app.custom_module) + активация; activeFor/isActive
Access/CustomRole                VO роли (key, label)
Access/CustomAccess              isModuleActive/assertModuleActive, hasRole/assertRole, roleIsAvailable
Feature/FeatureGateInterface     has(wsId, FeatureCodeEnum) / enabledFor(wsId)
Feature/FeatureGate              тариф ∪ активные модули ∪ гранты
Settings/SettingType             enum Bool|Int|Str
Settings/SettingDefinition       key/type/default/label + coerce()
Settings/SettingsProviderInterface  поставщик деклараций (тег app.settings_provider)
Settings/CoreSettingsProvider    глобальные настройки ядра (пока пусто)
Settings/SettingsCatalog         сбор деклараций + coerce(raw)
Settings/WorkspaceSettingsReader типизированное чтение (значение ∪ дефолт): bool/int/string
Entity/WorkspaceCustomModule/*   активация модуля (таблица workspace_custom_module)
Entity/WorkspaceFeatureGrant/*   точечный грант фичи (таблица workspace_feature_grant)
Entity/WorkspaceSettings/*       значения настроек (таблица workspace_settings)
Entity/CustomRoleAssignment/*    назначение роли (таблица custom_role_assignment)
Command/SetWorkspaceSettings/*   запись настроек (владелец)
Command/AssignCustomRole/*       назначить роль (владелец)
Command/RevokeCustomRole/*       снять роль (владелец)
Query/GetWorkspaceSettings/*     настройки для UI (участник)
```

### Doctrine-зеркала ядра (`src/Infrastructure/Doctrine/Domain/Customization/`)
`WorkspaceCustomModule`, `WorkspaceFeatureGrant`, `WorkspaceSettings`, `CustomRoleAssignment`
(+ их `*Repository`). Репо-интерфейс ↔ реализация связывается **автоматически** (Symfony
авто-алиас на единственную реализацию — явных алиасов в `services.yaml` не нужно).

### HTTP ядра (`src/Http/`)
```
Action/Customization/GetWorkspaceSettingsAction   GET  /api/v1/workspaces/{id}/settings
Action/Customization/SetWorkspaceSettingsAction   PUT  /api/v1/workspaces/{id}/settings
Action/Customization/AssignCustomRoleAction       POST /api/v1/workspaces/{id}/custom-roles
Action/Customization/RevokeCustomRoleAction       DELETE .../members/{userId}/custom-roles/{roleKey}
Admin/CustomAdminMenuContributorInterface         интерфейс контрибьютора админ-меню (тег app.custom_admin_menu)
Admin/DashboardController                          собирает пункты контрибьюторов (AutowireIterator)
```

### Клиентские модули (`src/Custom/{slug}/`)
Эталон — `src/Custom/Acme/` (бронирование столов). `src/Custom/README.md` — конвенция модуля.

### Конфиги (тронуты слоем)
```
config/services.yaml           _instanceof-теги: app.custom_module / app.settings_provider /
                               app.custom_admin_menu; !tagged_iterator для CustomModuleRegistry и
                               SettingsCatalog
config/packages/doctrine.yaml  маппинг Custom (prefix App\Custom, dir src/Custom) — одна запись на все модули
config/routes.yaml             custom_controllers: сканирует src/Custom → префикс /api/v1
```

### Таблицы и миграции
```
workspace_custom_module   Version20260712140000   активация модуля (ws_id, slug, is_enabled)
workspace_feature_grant   Version20260712150000   грант фичи (ws_id, feature)
workspace_settings        Version20260712160000   значения настроек (ws_id, setting_values JSON)
custom_role_assignment    Version20260712180000   роль участнику (ws_id, user_id, role_key)
custom_acme_reservation   Version20260712170000   пилот Acme (пример custom_{slug}_*)
```

## 5. Рецепты

### 5.1 Добавить глобальную настройку (Configure)
1. Добавь `SettingDefinition` в `CoreSettingsProvider::definitions()` (ключ, тип, дефолт, label).
2. Читай где нужно: `WorkspaceSettingsReader::bool|int|string($workspaceId, $key)`.
3. Значение меняется без деплоя: `PUT /api/v1/workspaces/{id}/settings` `{ "values": { "ключ": … } }`.
Настройка модуля — то же, но в своём `SettingsProviderInterface` (ключ префиксуй slug'ом).

### 5.2 Продать/проверить фичу (Capabilities)
- Вокабуляр фич — `App\Shared\Enum\Feature\FeatureCodeEnum` (закрытый). Новая продаваемая фича =
  новый case там.
- Источники доступа объединяет `FeatureGate::has($workspaceId, FeatureCodeEnum::X)`:
  тариф владельца (активная подписка → `Tarif::features`) ∪ `capabilities()` активных модулей ∪
  гранты (`workspace_feature_grant`).
- «Доплатил → включили»: строка в `workspace_feature_grant` (репо
  `WorkspaceFeatureGrantRepositoryInterface`). Эндпоинта на выдачу гранта пока нет — добавь при
  необходимости (владельческий, через `WorkspaceAccess`).

### 5.3 Новый клиентский модуль (Extend) — по шагам
Скопируй структуру `src/Custom/Acme/`. Для клиента `{slug}`:
1. **Манифест** `src/Custom/{Slug}/{Slug}Module.php extends AbstractCustomModule` — задай
   `slug()`, `title()`; при нужде `roles()`, `capabilities()`, `previousSlugs()`. Тег
   `app.custom_module` навесится сам.
2. **Сущность** `src/Custom/{Slug}/{Domain}/…` (доменная, public-props, `buildNew`/`assignId`) +
   `…RepositoryInterface`.
3. **Doctrine** `src/Custom/{Slug}/Infrastructure/Doctrine/…` (ORM `#[ORM\Table(name:
   'custom_{slug}_…')]`) + `…Repository extends ServiceEntityRepository implements …Interface`.
   Маппинг подхватится записью `Custom` в `doctrine.yaml` — конфиг менять не надо.
4. **Миграция** — в общей `migrations/` (единая история!), таблица `custom_{slug}_*`.
   `php bin/console make:migration` или руками по образцу `Version20260712170000`.
5. **Use-case** `Command/…` + `Query/…` (как в ядре). В хендлере гейти доступ:
   `CustomAccess::assertModuleActive($wsId, {Slug}Module::SLUG)` +
   `assertRole($wsId, $userId, {Slug}Module::ROLE_…)`.
6. **Эндпоинт** `src/Custom/{Slug}/Http/Action/…` c `#[Route('/workspaces/{workspaceId}/…')]`.
   Роут подхватит `custom_controllers` (префикс `/api/v1`, требует JWT).
7. **Роль** — объяви в `roles()` (`new CustomRole('{slug}.role_key', 'Название')`). Назначается
   `POST /api/v1/workspaces/{id}/custom-roles` `{ "user_id": …, "role_key": "…" }`.
8. **Админ-раздел** — `src/Custom/{Slug}/Http/Admin/{X}CrudController extends AbstractCrudController`
   + класс `implements App\Http\Admin\CustomAdminMenuContributorInterface` (тег навесится сам,
   `DashboardController` добавит пункты).
9. **Настройки модуля** — класс `implements SettingsProviderInterface` (ключи с префиксом slug).
10. **Активация** (данные!): строка в `workspace_custom_module` `(workspace_id, slug='{slug}',
    is_enabled=true)`. Без неё модуль невидим. Отдельного эндпоинта активации пока нет — вставь
    через БД/консоль или добавь владельческую команду.
11. **Тесты** модуля — свои, в `tests/Unit/Custom/{Slug}/…` (не завязывай на тесты ядра).

### 5.4 Проверить активность/роль в коде
```php
$customAccess->assertModuleActive($workspaceId, AcmeModule::SLUG); // иначе DomainException
$customAccess->assertRole($workspaceId, $userId, AcmeModule::ROLE_RESERVATION_MANAGER);
// владелец воркспейса неявно имеет все роли активных модулей
```

## 6. Как проверять (быстрый прогон)
```
php bin/console lint:container                         # DI собирается
php bin/console doctrine:schema:validate --skip-sync   # маппинг корректен
php bin/console debug:router | grep -E 'custom_|settings|custom-roles'  # роуты на месте
php bin/console debug:container --tag=app.custom_module # модули видны реестру
php bin/phpunit                                         # тесты + boundary-guardrail
```

## 7. Устойчивость к переименованию slug (гарантия)
- **Slug воркспейса** (поддомен): всё по `workspace_id` (иммутабельный PK) → смена безопасна.
- **Slug модуля**: `slug()` — стабильная идентичность (= папка = префикс таблиц), `title()` —
  переименуемое отображение. Сменил идентичность — объяви старое в `previousSlugs()`, реестр
  сопоставит активации по эффективному slug (текущий ∪ прежние), без миграции данных. Конфликт
  двух модулей за один эффективный slug → `LogicException` при сборке реестра.
- **Гранты/роли/настройки**: ключ `workspace_id` (+ `FeatureCodeEnum`/`user_id`/ключ) — от slug
  не зависят.

## 8. Подводные камни (усвоенные уроки)
- **`private const` в анонимных классах тестов недоступны** — в тест-фикстурах константы делай
  `public const` (иначе `Error: Cannot access private constant`).
- **`values` — зарезервированное слово в Postgres** — колонка настроек названа `setting_values`
  (`#[ORM\Column(name: 'setting_values')]`), свойство осталось `values`.
- **Репо-интерфейс → реализация** алиасится Symfony автоматически (единственная реализация).
  Явный алиас в `services.yaml` не нужен.
- **Теги навешиваются через `_instanceof`** — реализуй нужный интерфейс, тег появится сам;
  ручной тег в описании сервиса не требуется.
- **Миграции кастома — в общей `migrations/`** (единая история/один `migrate`), не в модуле.
  Таблицы `custom_{slug}_*`.
- **`capabilities()` vs активность:** продаваемая глобальная фича → `FeatureCodeEnum` +
  `FeatureGate`. Бесповеденческая клиентская фича (как брони Acme) гейтится **активностью модуля**
  (`isModuleActive`), а `capabilities()` пуст — это норма.
- **Эндпоинты `/api/v1` требуют JWT** (файрвол `api`). Публичных гостевых кастом-эндпоинтов
  каркас пока не разводит по префиксу — при нужде заводи отдельно.

## 9. Что дальше
- **Срез 4 — Replace.** Обобщить `App\Infrastructure\Payment\WorkspaceOrderPaymentGatewayFactory`
  (`forWorkspace(int): T`) в переиспользуемый `TenantStrategyResolver`: ядро зависит от порта
  через резолвер, кастомная реализация выбирается по активному модулю воркспейса, иначе дефолт.
  Кандидат на первый порт — `App\Application\Order\Pricing\OrderPricingInterface`.
- **Срез 5 — DevX.** Консоль `app:custom:new {slug}` (скаффолд модуля по эталону Acme),
  `app:custom:doctor` (валидация: дубли slug/ключей, осиротевшие активации).
- **Мелочи-долги:** эндпоинт активации модуля владельцем; эндпоинт выдачи гранта фичи; тесты
  для пилота Acme и хендлеров записи (`SetWorkspaceSettings`, `AssignCustomRole`).
