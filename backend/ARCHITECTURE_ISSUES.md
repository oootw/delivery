# Архитектурный аудит бэкенда (2026-07-12)

Проверка соблюдения правил `architecture.md` (DDD, порты/адаптеры, границы слоёв,
мультитенантность, именование) по текущему коду. Найденное отсортировано по критичности;
статус проставляется по мере исправления.

> **Важно про природу находок.** Это дефекты **границ слоёв и структурной консистентности**,
> а не runtime-/security-баги: приложение собирается (`lint:container` OK), тесты зелёные
> (`phpunit` 55/55), тенант-изоляция и IDOR-гарды на месте (см. «Проверено — нарушений нет»).
> Исправлять можно инкрементально, не блокируя фичи. Каждая находка самодостаточна для
> холодной сессии: указаны файлы, суть нарушения и план фикса.

---

## 🟠 A1. Application-слой зависит от Infrastructure через доменные события — ✅ ИСПРАВЛЕНО (2026-07-12)

**Где было.** `src/Application/Authorize/Events/OnBeforeSaveNewUser/OnBeforeSaveNewUserEvent.php`,
`src/Application/Authorize/Events/OnAfterSaveNewUser/OnAfterSaveNewUserEvent.php` — конструктор/`getUser()`
типизированы Doctrine-сущностью `App\Infrastructure\Doctrine\Domain\Users\User`. Диспатчатся из
`Infrastructure/Doctrine/Domain/Users/UserRepository::create()`.

**Почему критично.** Прямое нарушение: доменный слой (`Application`) **не должен знать про
Doctrine/Infrastructure** (`architecture.md` §1, §14). ORM протекала в домен через payload событий.

**Фикс.** События переведены на доменные типы (Application больше не импортирует Infrastructure —
перепроверено грепом): `OnBeforeSaveNewUserEvent` несёт `string $phone` (до save id ещё нет),
`OnAfterSaveNewUserEvent` несёт доменный `App\Application\Authorize\Entity\User\User` (`getUser()`/
`getUserId()`). `UserRepository::create()` диспатчит phone до flush и `EntityUser::buildNew($id)` после;
удалены мёртвые импорты несуществующих `CreateNewUserEvent`/`CreateNewUserEventPayload`. Риск нулевой:
у событий **нет ни одного слушателя** (диспатчатся, не потребляются). Проверено: Application без
Infrastructure-импортов, `lint:container` OK, `php -l` OK, `phpunit` 55/55.

**Осознанно отложено (смежное, не A1).** Доменная модель `User` остаётся id-holder (`buildNew(int $id)`),
`findByPhone` пробрасывает только id — полноценное моделирование домен-User вынести отдельно (связано
с A2, где Doctrine-маппинг User переносится в `Domain/Authorize/User`).

---

## 🟡 A2. Doctrine-маппинг User лежит в чужой доменной папке (`Domain/Users`, а домен — `Authorize`) — ✅ ИСПРАВЛЕНО (2026-07-12)

**Где было.** `src/Infrastructure/Doctrine/Domain/Users/{User,UserRepository}.php` — при том что
репозиторий реализует `App\Application\Authorize\Entity\User\UserRepositoryInterface` (инфраструктура
домена **Authorize**). Осиротевшая папка от удалённого на M0 домена `Users`.

**Почему.** Нарушало «инфраструктура домена зеркалит структуру домена» (`architecture.md` §2, §7).

**Фикс.** `git mv` в `src/Infrastructure/Doctrine/Domain/Authorize/User/` (namespace
`App\Infrastructure\Doctrine\Domain\Authorize\User`, паттерн как `Authorize/Code`, `Authorize/Token`).
Обновлены ВСЕ ссылки: `Audit/AuditSubscriber` (`User::class` в whitelist), `Shared/Console/GrantAdminCommand`,
`Http/Admin/UserCrudController`, `Doctrine/Domain/Authorize/Token/{Token,TokenRepository}`, и главное —
**`config/packages/security.yaml`** (entity-провайдер `class:`). Старая папка `Domain/Users` удалена.
**Имя таблицы `` `user` `` не менялось** — только namespace/расположение, миграция не нужна. Проверено:
нигде не осталось `Domain\Users`, `php -l` OK, `lint:container` OK, `doctrine:mapping:info` (User под
`Authorize\User`), `schema:validate` mapping OK, `phpunit` 55/55, `cache:clear` OK.

**Осознанно отложено (смежное, не A2).** Доменная модель `User` всё ещё id-holder (`buildNew(int $id)`,
`findByPhone` пробрасывает только id) — полноценное моделирование домен-User (phone/isActive/etc.)
вынести отдельным шагом; сам маппинг теперь на месте.

---

## 🟡 A3. Shared-слой зависит от Application и Infrastructure (инверсия слоёв) — ✅ ИСПРАВЛЕНО (2026-07-12)

**Где было.** `src/Shared/Console/*` (5 команд) импортировали use-case'ы `Application`;
`GrantAdminCommand` тянул **Infrastructure** Doctrine-`User` + `EntityManager` напрямую.

**Почему.** `src/Shared` (`architecture.md` §1) — нижний переиспользуемый слой. Консольные команды —
это entry-point (аналог `Http`), их размещение в `Shared` делало нижний слой зависимым от
`Application`/`Infrastructure` (инверсия); `GrantAdminCommand` ещё и мутировал Doctrine-сущность в обход портов.

**Фикс.**
1. **Новый entry-point слой** `src/Console` (namespace `App\Console`) — задокументирован в
   `architecture.md` §1. Все 5 команд перенесены туда (`app:admin:grant`, `app:orders:expire-abandoned`,
   `app:wait-time:recalculate`, `app:subscriptions:cancel-past-due`, `app:loyalty:expire-points`).
   `Shared` теперь чист (перепроверено грепом: нет `use App\Application`/`use App\Infrastructure`).
2. **GrantAdmin через порты.** Доменный use-case `Authorize/Command/GrantAdmin/{GrantAdminCommand,GrantAdminHandler}`;
   порт хэширования `Authorize/Security/PasswordHasherInterface` + адаптер `Infrastructure/Security/AdminPasswordHasher`
   (поверх Symfony `UserPasswordHasherInterface`); метод порта `UserRepositoryInterface::promoteToAdmin(phone, hashedPassword)`.
   Консольная команда `App\Console\GrantAdminCommand` теперь зовёт только Handler — ни `EntityManager`, ни
   Doctrine-сущности. Alias порта в `services.yaml`. Проверено: `lint:container` OK, `list app` (5 команд),
   `php -l` OK, `phpunit` 55/55, `cache:clear` OK.

---

## 🟢 A4. Запрещённые имена методов (`resolve*`) — naming-debt — ✅ ИСПРАВЛЕНО (2026-07-12)

**Где было.** `PromotionPricing::resolvePromocode`, `GetClientProductByIdFetcher::resolveModifierGroups`,
`GetMenuByVenueIdFetcher::resolveModifierGroups` (`architecture.md` §11/§14 запрещает `ensure/resolve/process`).

**Фикс.** Переименованы по намерению: `resolvePromocode` → `requireApplicablePromocode` (идиома проекта,
как `WorkspaceAccess::requireMember` — валидирует и бросает); оба `resolveModifierGroups` → `buildModifierGroups`
(собирают view модификаторов). Приватные методы, правки локальны. Проверено: запрещённых имён во всём
`Application/Infrastructure/Console` нет, `php -l`/`lint:container`/`phpunit` 55/55 OK. Прим.: класс-роли
`*Resolver`/`TierResolver` — описательные имена сервисов (прецедент в проекте), A4 их не касался.

---

## Проверено — нарушений нет (чтобы холодная сессия не перепроверяла)

- **IDOR / принадлежность.** Мутации/чтения по id проверяют владение через воркспейс сущности:
  `UpdatePromotion` (getOwnedWorkspace по `promotion->workspaceId`), `GetOrderById`
  (`order->customerId === userId` + staff-гард → «Нет доступа к заказу»). Гость чужой заказ не прочитает.
- **Мультитенантность.** Тенант-репозитории фильтруют по `workspace_id`; доступ владельца — через
  `WorkspaceAccess` (после аудита #7 требует активную подписку на мутациях).
- **ORM в домене.** В `src/Application` нет `#[ORM\...]` и `use Doctrine\...` (кроме A1-событий).
- **try-catch в нижних слоях.** В Doctrine-репозиториях `catch` нет. `catch` в
  `PromotionConditions` (перевод ошибки парсинга даты в `\DomainException`), `ImportMenuHandler`
  и `CancelStalePastDueSubscriptionsHandler` (устойчивая оркестрация/перевод чужого исключения) —
  разрешённые `architecture.md` §3 исключения.
- **Маппинг репозиториев.** Все Doctrine-репозитории мапят в доменные сущности (`buildNew`/`toEntity`),
  включая `CodeRepository` (`new EntityCode(...)`).
- **EasyAdmin.** `Http/Admin/*CrudController` работают с Doctrine-сущностями — это неотъемлемое
  свойство EasyAdmin (read-only админка, M8), не считается нарушением портов.
- **Платежи (2026-07-12).** Контракты в `Shared/Contract/Payment`, per-workspace резолвер, ЮKassa —
  границы соблюдены (порты в Shared/Contract, адаптеры в Infrastructure).

---

## Статус: все пункты закрыты (2026-07-12)

A1, A2, A3, A4 — ✅ ИСПРАВЛЕНО (см. блоки выше). Каждый проверен: `lint:container`, `php -l`,
`phpunit` 55/55; A2/A3 дополнительно `cache:clear` OK.

**Доменная модель `User`** — ✅ уточнена (2026-07-12). Была id-holder (`buildNew(int $id)`), стала
`User { id, phone }` (телефон — естественный ключ/логин; `findByPhone` больше не выбрасывает phone,
который сам же и искал). Смапплено в `UserRepository` (findByPhone + событие OnAfterSave), отражено
в `FindUserByPhone/UserDTO`. **Осознанно НЕ добавлены** isActive/isAdmin/password/профиль — у них нет
доменных потребителей (все читают только id/факт существования), а учётные данные/права админки —
концерн Infrastructure/Security (Doctrine-`User` несёт эти поля). Добавлять при появлении реального
доменного потребителя, не спекулятивно (`architecture.md`: агрегаты/VO — только по необходимости).
