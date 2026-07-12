# ADR + план: система кастомизации под отдельного владельца (2026-07-12)

**Статус:** предложение (черновик к внедрению).
**Автор решения:** архитектурная проработка по запросу владельца продукта.

## 1. Контекст и цель

Основное приложение продаётся по подписке (домен `Subscription`/`Tarif`). Доработки делятся
на два потока, которые нельзя смешивать в коде:

1. **Глобальные** — едут всем подписчикам (новые фичи ядра, дефолтное поведение).
2. **Локальные (платные)** — под конкретного владельца/воркспейс: своя доменная логика,
   новые эндпоинты и сущности, **новые роли и разделы админки**, замена отдельных стратегий
   ядра. Монетизируются отдельно.

Что считается «локальным» (уточнено владельцем): тарифы и зарегистрированные пользователи —
**глобальное**; всё, что привязано к воркспейсу/владельцу — **локальное**, вплоть до ролей и
админки.

**Цель ADR:** зафиксировать структуру, при которой глобальные обновления никогда не ломают
клиентский кастом, а клиентский кастом добавляется/снимается без касания ядра — максимально
поддерживаемо и расширяемо.

## 2. Решение (кратко)

Кастом добавляется по **лестнице из трёх режимов** — всегда выбираем самый нижний, что решает
задачу:

| Режим | Что делает | Где живёт | Деплой ядра |
|-------|-----------|-----------|-------------|
| **Configure** | Меняет данные/параметры | `WorkspaceSettings` (БД) | нет |
| **Extend** | Добавляет новое (эндпоинты, сущности, роли, разделы админки, подписчики событий) — *аддитивно* | `src/Custom/{slug}/…` | да, изолированно |
| **Replace** | Подменяет стратегию ядра за стабильным портом, по воркспейсу | `src/Custom/{slug}/…` + `TenantStrategyResolver` | да, изолированно |

Опора — **паттерны, которые уже есть в коде**: порты/адаптеры (`services.yaml`-алиасы) и
резолвер стратегии по воркспейсу (`WorkspaceOrderPaymentGatewayFactory::forWorkspace()`). Мы
их обобщаем в осознанный слой кастомизации, а не строим с нуля.

**Главный инвариант (без него всё разваливается):**

> Ядро (`App\Application`, `App\Infrastructure`, `App\Http`) **никогда** не ссылается на
> `App\Custom\*` и не содержит `if ($workspaceId === …)`. Кастом либо данные, либо реализация
> за стабильным интерфейсом, выбираемая по воркспейсу через реестр/резолвер. Ядро не знает
> имён клиентов.

## 3. Архитектура

### 3.1. Каркас (core-owned, `src/Shared/Customization/`)

```
Shared/Customization/
├─ Contract/
│  ├─ CustomModuleInterface.php          # манифест клиентского модуля (точка входа)
│  ├─ TenantStrategyResolverInterface.php# обобщённый выбор стратегии по воркспейсу
│  ├─ CapabilityResolverInterface.php    # can(workspaceId, Capability): bool
│  └─ Capability.php                      # перечень платных/фичевых возможностей
├─ Context/TenantContext.php             # request-scoped: текущий workspaceId + активный slug
├─ Registry/CustomModuleRegistry.php     # tagged-iterator всех модулей; activeFor(workspaceId)
├─ Resolver/TenantStrategyResolver.php   # реализация Replace (см. 3.4)
├─ Capability/CapabilityResolver.php     # тариф + гранты (см. 3.5)
├─ Entity/WorkspaceCustomModule*         # активация модуля = данные (см. 3.3)
└─ Entity/WorkspaceCapabilityGrant*      # платный грант возможности воркспейсу
```

`CustomModuleInterface` — единственная точка, которую реализует каждый клиентский модуль:

```php
interface CustomModuleInterface
{
    public function slug(): string;                 // 'acme'
    /** @return list<Capability> что модуль открывает */
    public function capabilities(): array;
    /** @return list<CustomRole> новые роли + их права */
    public function roles(): array;
    /** @return iterable<MenuItem> разделы EasyAdmin (пусто — нет админки) */
    public function adminMenu(): iterable;
}
```

Модули помечаются тегом `app.custom_module` → `CustomModuleRegistry` собирает их
`AutowireIterator`-ом. **Наличие кода не активирует модуль** — активность определяется данными
(3.3).

### 3.2. Директория клиента (`src/Custom/{slug}/`)

Один каталог на клиента, **зеркалит структуру ядра** — знакомая навигация, ничего нового
учить не нужно:

```
src/Custom/Acme/
├─ AcmeModule.php                  # implements CustomModuleInterface (манифест)
├─ Application/{Domain}/…          # новые use-case'ы, сущности, стратегии
├─ Infrastructure/…               # Doctrine-маппинги, адаптеры портов
├─ Http/Action/…                  # кастомные эндпоинты (роут-атрибуты)
├─ Http/Admin/…                   # кастомные EasyAdmin CRUD
├─ migrations/                    # таблицы custom_acme_*
└─ Resources/config/services.yaml # DI-проводка модуля (теги, алиасы)
```

**Правило зависимостей:** `App\Custom\*` зависит от `App\Application\*`/`App\Shared\*` (ядро),
**но не наоборот**. Проверяется автоматически (3.7).

### 3.3. Активация = данные (`WorkspaceCustomModule`)

Таблица `workspace_custom_module`: `workspace_id → slug, enabled_at`. `CustomModuleRegistry
::activeFor(workspaceId)` читает её и возвращает активный модуль (или `null`). Следствия:

- установить кастом = задеплоить папку + **вставить строку** (или включить через админку);
- снять клиента = удалить строку (код может остаться дремать, удаляется позже);
- ядро и другие клиенты не затронуты.

Один основной модуль на воркспейс (рекомендация); при нужде — список, но резолверы стратегий
берут первый предоставляющий нужный порт.

**Устойчивость к переименованию slug (гарантия).** Кастомизация не «слетает» ни при каких
переименованиях:

- **Slug воркспейса** (поддомен): вся привязка идёт по числовому `workspace_id` (иммутабельный
  PK), а не по slug. Владелец может сменить поддомен/бренд — активации, гранты и стратегии
  сохраняются.
- **Slug модуля**: `slug()` — стабильная идентичность (= папка = префикс таблиц `custom_{slug}_*`),
  `title()` — свободно переименуемое отображение. Если идентичность всё же меняют, модуль
  объявляет старые значения в `previousSlugs()`, и `CustomModuleRegistry` сопоставляет активации
  по эффективному slug (текущий ∪ прежние) — записи `workspace_custom_module` со старым slug
  продолжают работать без миграции данных. Конфликт двух модулей за один эффективный slug —
  ошибка конфигурации (регистр бросает при сборке).
- **Гранты фич**: ключуются на `workspace_id` + `FeatureCodeEnum` — не зависят ни от одного slug.

### 3.4. Replace — `TenantStrategyResolver` (обобщение платёжной фабрики)

Сейчас `WorkspaceOrderPaymentGatewayFactory implements OrderPaymentGatewayResolverInterface`
делает ровно это для платежей. Обобщаем в переиспользуемый механизм:

```
Ядро зависит от порта T (напр. OrderPricingInterface) НЕ напрямую, а через резолвер:
    $impl = $resolver->forWorkspace($workspaceId);   // кастом, если активен; иначе дефолт
```

Кастомные реализации тегируются `app.tenant_strategy` с атрибутами `{ port, slug }`. Резолвер
индексирует их по `(port, slug)` и на рантайме выбирает по активному модулю воркспейса, иначе —
дефолтную реализацию (та, что едет всем). Это тот же паттерн `forWorkspace(): T`, что уже
работает для CloudPayments/ЮKassa — просто вынесенный из платежей в `Shared/Customization`.

`TenantContext` (request-scoped) хранит текущий `workspaceId`; заполняется kernel-listener'ом
из роут-параметра `{workspaceId}`, а где его нет — из владения ресурсом. Порт в JWT не кладём
(в `Claims` его и нет — не ломаем токен).

### 3.5. Capabilities — единый гейт (монетизация)

`CapabilityResolver::can(workspaceId, Capability)` читает **три источника** и объединяет:

1. **тариф подписки** (`Tarif`/`TarifLimits`) — глобальные фичи по плану;
2. **возможности активного модуля** (`CustomModuleInterface::capabilities()`);
3. **точечные гранты** — таблица `workspace_capability_grant` (тут живёт «доплатил — включили»).

`TarifLimits` (сейчас `match` по коду тарифа) поглощается этим резолвером как источник №1 —
без слома текущего поведения. Платная локальная фича = грант возможности + (при нужде) модуль
Extend/Replace. Грант можно связать со счётом в `Billing` (отдельная строка монетизации).

### 3.6. Роли и админка (важно — запрошено явно)

**Новые роли.** Воркспейсы уже имеют staff-членов (`AddStaffMember`/`RemoveStaffMember`).
Кастомный модуль отдаёт роли через `roles()`; `CustomRoleProvider` собирает их из активного
модуля, роль хранится у staff-члена воркспейса, а `PermissionVoter` сверяется с реестром прав.
Ядро знает про механизм ролей, но не про конкретные роли клиента.

**Разделы админки.** `DashboardController::configureMenuItems()` (сейчас статичный список)
дополняется циклом по активным модулям: их `adminMenu()` добавляет пункты, ведущие на CRUD из
`Custom/{slug}/Http/Admin`. Разделы видны только там, где модуль активен.

### 3.7. Guardrail (то, что удерживает систему поддерживаемой)

- **deptrac / архитектурный тест в CI:** слои `App\Application|Infrastructure|Http` не имеют
  права импортировать `App\Custom\*`. Нарушение — красный CI. Ложится в дисциплину
  `ARCHITECTURE_ISSUES.md`.
- **Свои тесты у каждого модуля** — не зависят от тестов ядра.
- **Единственная точка «знания» о кастоме** — теги DI и таблица активации, а не классы в ядре.
- **Соглашение об именах таблиц** `custom_{slug}_*` — исключает коллизии и делает владение
  очевидным; кастомные миграции лежат в `Custom/{slug}/migrations`.

### 3.8. Роутинг и самозащита эндпоинтов

Добавляем в `config/routes.yaml` ресурс сканирования `src/Custom/*/Http/Action/`
(prefix `/api/v1`, type attribute) и `…/Http/Admin/`. Кастомный экшен сам проверяет активность
модуля/возможности для воркспейса и при отсутствии — отдаёт **404** (не 403), чтобы не палить
существование платной фичи.

## 4. Поток разрешения (рантайм)

```
Запрос → TenantContext(workspaceId)
      → CapabilityResolver.can(ws, Cap)?          # тариф ∪ модуль ∪ грант
      → CustomModuleRegistry.activeFor(ws)         # данные: workspace_custom_module
      → ядро вызывает порт T через TenantStrategyResolver.forWorkspace(ws)
             ├─ активный модуль даёт реализацию T → кастом
             └─ иначе                              → дефолт (едет всем)
```

## 5. Отображение на монетизацию

| Тип доработки | Как реализуется | Как продаётся |
|---------------|-----------------|----------------|
| Глобальная фича | ядро + дефолтный адаптер + capability тарифа | входит в подписку |
| Платная настройка | `WorkspaceSettings` (Configure) | разовая/включение |
| Платная фича клиента | грант capability + модуль Extend | грант ↔ счёт в `Billing` |
| Своё поведение ядра | модуль Replace за портом | грант + модуль |

## 6. Стабильность контрактов

- Порты живут в ядре (`Application/{Domain}` или `Shared/Contract`), версионируются.
  Ломающее изменение = **новый порт**, старый держим до миграции модулей.
- **Глобальное обновление** трогает ядро + дефолтные реализации; модули не затронуты, т.к.
  сидят за стабильными портами либо аддитивны.
- **Локальное обновление** трогает только `Custom/{slug}/`; ядро не затронуто.

## 7. Рассмотренные альтернативы (упаковка кода)

| Вариант | Изоляция | Ops | Вердикт |
|---------|----------|-----|---------|
| **A. Монорепо + `src/Custom/{slug}`, гейт данными** | средняя | минимум | **выбран для старта** |
| B. Приватные composer-пакеты на клиента | высокая | средняя | миграция из A, когда кастомов много/жирные |
| C. Одно-тенантный деплой (форк) для «китов» | максимальная | высокая | только под инфра-изоляцию отдельных клиентов |

A и B **по коду идентичны** (изолированный неймспейс + теги + манифест) → переезд A→B чисто
механический (вынести папку в пакет). C по умолчанию отвергнут: N деплоев × каждое глобальное
обновление = неподдерживаемо; держим C точечно.

## 8. Анти-паттерны (запрещено)

- `if ($workspaceId === 42)` / `switch (slug)` в ядре.
- Импорт `App\Custom\*` из ядра.
- Активация кастома через деплой-флаг в коде вместо строки данных.
- Ломающее изменение существующего порта ради одного клиента (заводим новый порт).
- Клиентская логика в общих таблицах ядра (заводим `custom_{slug}_*`).

## 9. План внедрения (срезы)

- **Срез 0 — Каркас, без клиентов. ✅ СДЕЛАНО (2026-07-12).** `CustomModuleInterface`
  (`Application/Customization/Contract`), `CustomModuleRegistry` (тег `app.custom_module` +
  `!tagged_iterator`), домен `WorkspaceCustomModule` (Application-сущность + репо-интерфейс +
  Doctrine-зеркало) + миграция `Version20260712140000` (таблица `workspace_custom_module`),
  папка-конвенция `src/Custom/` (README), арх-guardrail `tests/Unit/Architecture/
  CustomizationBoundaryTest` (ядро не ссылается на `App\Custom`), unit-тесты реестра.
  Поведение не изменилось: `lint:container` OK, `schema:validate` OK, phpunit 60/60.
  **Отклонения от плана (осознанные):** (1) отдельный `TenantContext` не заводил — уже есть
  `App\Http\Workspace\WorkspaceContext` (slug из поддомена) + конвенция «workspaceId явным
  параметром»; резолвленный контекст добавим, когда его потребует Replace (срез 4). (2) Ресурс
  роутинга `src/Custom/` не подключал — пока нет модулей; добавится в срезе 3 вместе с первым
  эндпоинтом (зафиксировано в `src/Custom/README.md`). (3) deptrac не ставил (нет в проекте) —
  guardrail сделан phpunit-тестом, без новой зависимости.
- **Срез 1 — Configure. ✅ СДЕЛАНО (2026-07-12).** Декларативный механизм настроек воркспейса
  (`Application/Customization/Settings`): `SettingType`/`SettingDefinition` (ключ, тип, дефолт,
  валидация/приведение), `SettingsProviderInterface` (тег `app.settings_provider`) → `SettingsCatalog`
  (сбор деклараций + `coerce()` «сырых» значений, отказ на неизвестный ключ/тип), `CoreSettingsProvider`
  (пока пусто — глобальные настройки заводятся под реальный запрос), `WorkspaceSettingsReader`
  (типизированное чтение: значение ∪ дефолт). Домен `WorkspaceSettings` (JSON-карта `setting_values`,
  миграция `Version20260712160000`). Запись — `SetWorkspaceSettings` (владелец, через `WorkspaceAccess`),
  чтение — `GetWorkspaceSettings` (участник). HTTP: `GET/PUT /api/v1/workspaces/{id}/settings`. phpunit
  77/77, `lint:container`/`schema:validate` OK. **Ключевая идея:** схема настроек — в коде (провайдеры,
  в т.ч. клиентские модули), значения per-workspace — в данных: сменить значение клиенту можно без
  деплоя, а кастом-модуль расширяет поверхность настроек своим провайдером, не трогая ядро.
- **Срез 2 — Capabilities. ✅ СДЕЛАНО (2026-07-12).** Реализовано поверх существующего
  `FeatureCodeEnum` (не заводили параллельный `Capability`): `FeatureGateInterface`/`FeatureGate`
  (`Application/Customization/Feature`) объединяет три источника — тариф владельца
  (Workspace.ownerId → `findActiveByUser` → `getByTarifCode` → `Tarif.features`), возможности
  активных модулей (`CustomModuleInterface::capabilities(): FeatureCodeEnum[]`) и точечные гранты
  (`workspace_feature_grant`, миграция `Version20260712150000`). Домен `WorkspaceFeatureGrant`
  (Application-сущность + репо + Doctrine-зеркало). phpunit 66/66, `lint:container`/`schema:validate`
  OK. **Отклонения:** таблица названа `workspace_feature_grant` (а не `…capability…`) — единый
  словарь «feature» с ядром; `TarifLimits` (лимиты воркспейсов) не поглощали — это про количество,
  а не про доступ к фичам, оставлен как есть.
- **Срез 3 — Extend (пилот). ✅ СДЕЛАНО (2026-07-12).** Каркас расширения + эталонный модуль
  `Custom/Acme` (бронирование столов), сквозь весь стек. **Каркас:** роутинг `src/Custom` →
  `/api/v1` (`custom_controllers` в routes.yaml); Doctrine-маппинг `Custom` (одна запись на все
  модули); роли — `CustomRole` + `CustomModuleInterface::roles()` + домен `CustomRoleAssignment`
  (таблица `custom_role_assignment`) + `CustomAccess` (`isModuleActive`/`hasRole`; владелец имеет
  все роли активных модулей; роль действует только пока модуль активен) + команды `AssignCustomRole`/
  `RevokeCustomRole` (владелец) с эндпоинтами; контрибьютор админ-меню
  `CustomAdminMenuContributorInterface` (тег `app.custom_admin_menu`) — `DashboardController`
  собирает разделы, не зная классов клиента. **Пилот Acme:** сущность `Reservation` +
  Doctrine-зеркало + миграция `custom_acme_reservation` (`Version20260712170000`); эндпоинты
  `POST/GET /api/v1/workspaces/{id}/acme/reservations` (гейтинг: модуль активен + роль
  `acme.reservation_manager`); `AcmeSettingsProvider` (настройка `acme.reservations.lead_time_minutes`,
  читается `WorkspaceSettingsReader` в хендлере); EasyAdmin `ReservationCrudController` +
  `AcmeAdminMenuContributor`. phpunit 83/83, `lint:container` OK, `schema:validate` OK, роуты
  зарегистрированы, boundary-тест зелёный (ядро не ссылается на `App\Custom`). **Отклонения:**
  миграции кастома — в общей `migrations/` (единая история), а не в модуле (прагматичнее для
  монорепо); `capabilities()` пилота пуст — бесповеденческая фича гейтится активностью модуля.
- **Срез 4 — Replace.** Обобщить `WorkspaceOrderPaymentGatewayFactory` →
  `TenantStrategyResolver`; перевести платежи на него как эталон; включить per-tenant подмену
  для одного порта ядра (напр. `OrderPricingInterface`).
- **Срез 5 — DevX/Ops.** CLI-скаффолдер модуля (`app:custom:new {slug}`), валидатор модуля
  (`app:custom:doctor`), документация для разработчика кастома.

## 10. Открытые вопросы

- Именование `slug`: код клиента vs slug воркспейса (если у клиента несколько воркспейсов).
- Гранулярность `Capability`: домен-уровень vs фича-уровень.
- Связь `WorkspaceCapabilityGrant` ↔ `Billing` (автосчёт при выдаче гранта) — отдельным срезом.
- Нужен ли одновременно >1 активный модуль на воркспейс (по умолчанию — один).
