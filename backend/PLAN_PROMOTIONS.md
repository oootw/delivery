# План: Скидки, промокоды и бонусная система (веха M9)

> Отдельный план для крупной подсистемы «скидки + промокоды + лояльность». Основной
> роадмап — `PLAN.md` (проект дошёл до M8). Этот документ самодостаточен: холодная
> сессия должна суметь начать реализацию, прочитав только его + раздел 0 ниже.
> Архитектурные соглашения — `architecture.md` и авто-память `delivery-backend-conventions`.

---

## 0. Быстрый старт для холодной сессии (читать первым)

**Что за проект.** Symfony 8.1 / PHP 8.4 / PostgreSQL 16 / Doctrine ORM 3, DDD (порты и
адаптеры). Агрегатор доставки еды: владелец платит подписку → создаёт воркспейс →
точки (Venue) → подключает POS (iiko) и импортит меню → гости делают заказы (Order),
оплата онлайн CloudPayments, статусы, ETA (WaitTime). Есть глобальная админка (EasyAdmin).

**Слои (строго соблюдать):**
- `src/Application/{Domain}` — домен: `Entity/` (сущность + `RepositoryInterface`, enum'ы, VO),
  `Command/{UseCase}/` (Command + Handler), `Query/{UseCase}/` (Query + Fetcher + View),
  `Service/`, `Events/`. **Без Doctrine и HTTP.**
- `src/Infrastructure/Doctrine/Domain/{Domain}` — ORM-сущности (геттеры/сеттеры) + реализации репозиториев.
- `src/Http/Action/{Domain}` — контроллеры-Action (по одному действию на класс).
- `src/Shared` — общее.

**Соглашения (обязательны):**
- `try-catch` по умолчанию **только в Action**; в домене бросаем `\DomainException`
  (сообщения на **русском**, без `use` — просто `throw new \DomainException('...')`).
- Внутри Action бизнес-ошибки ловим `catch (InvalidArgumentException | \DomainException)` → 400 через `ApiResponse`.
- Репозитории: `find...` → nullable, `get...` → бросает. Свойства-репозитории в Handler —
  во множественном числе без суффикса (`$promotions`, `$orders`).
- Именованные аргументы всегда; фабрика `buildNew(...)` на доменных сущностях; `assignId(int)` после save.
- Запрещены «пустые» имена: `ensure`, `resolve`, `process`, безликие `Manager`/`Data`/`Helper`.
  Код читается линейно сверху вниз.
- Деньги — **в копейках, `int`** (`...Kopecks`). Проценты — **в базисных пунктах** (`int`,
  10000 = 100%), чтобы не тащить float. Валюта пока только RUB.
- Мультитенантность: **одна БД + `workspace_id`** во всех тенант-таблицах (+ индекс).
  `workspaceId` передаётся в use-case явным параметром; репозитории фильтруют по нему.
- Владелец конфигурирует только свой воркспейс: use-case берёт воркспейс через
  `App\Application\Workspace\Service\WorkspaceAccess::getOwnedWorkspace(userId, workspaceId)`
  (мутации) / `requireMember(...)` (чтение). Гостевые операции — по `customerId` из JWT.
- Каждая новая таблица/поле — миграция `doctrine-migrations` (`migrations/Version2026MMDDHHMMSS.php`).
  Последняя занятая — `Version20260708200000`; новые нумеровать по дате реализации.
- Ответы API — через `App\Http\Response\ApiResponse` (единый формат). Read-model — отдельный `View`-класс.
- Проверка DI после изменений: `php bin/console lint:container` (нужен установленный `vendor/`).
  **Пользователь ставит зависимости и гоняет миграции сам — не запускать `composer install`/`migrate` без явной просьбы.**

**Процесс (важно):** перед **каждым новым use-case** задавать дотошные уточняющие вопросы
(см. открытые вопросы в каждом под-этапе). Реализация — вертикальными срезами.

---

## 1. Зафиксированные решения (согласованы 2026-07-09)

1. **Организация доменов:** два домена —
   - `Application/Promotion` — **скидки и промокоды** как разные типы одной сущности `Promotion`
     (общий движок применения к заказу `PromotionEngine`).
   - `Application/Loyalty` — **бонусная система целиком**: кошелёк баллов (кэшбэк), уровни (tiers),
     штампы (stamp-card). Общий сервис расчёта/начисления.
2. **Уровни (tiers):** считаются по **сумме трат за всё время** (lifetime spend). Уровень только растёт.
3. **Стекинг (комбинирование скидок/промокодов/баллов):** **настраивается приоритетом** — у каждого
   правила `priority` (int) и флаг `stackable` (bool). Движок сортирует по приоритету и применяет,
   пока встречает `stackable`; на первом не-`stackable` берёт лучшую и останавливается. Баллы —
   отдельный слой поверх, со своим лимитом.
4. **Область применения скидок:** **полный набор** сразу — цель (`target`: весь заказ / позиция / категория)
   + условия (`conditions`: мин. сумма, тип заказа, временнОе окно/happy hours + дни недели,
   только первый заказ, срок действия `validFrom/validTo`, привязка к точке).

**Открытые вопросы (закрыть ПЕРЕД реализацией соответствующего под-этапа):**
- Курс балла: 1 балл = 1 копейка или 1 балл = 1 рубль? (влияет на `pointValueKopecks`). — *по умолчанию в плане: 1 балл = 1 рубль = 100 копеек.*
- База начисления кэшбэка: от суммы **после** скидок (net paid) или от subtotal? — *по умолчанию: net paid.*
- Момент начисления баллов: на `paid` или на `completed`? — *по умолчанию: `completed` (не начисляем за отменённые).*
- Сгорают ли баллы (`pointsLifetimeDays`)? — *по умолчанию: не сгорают (nullable).*
- Минимальная оплачиваемая сумма заказа после всех скидок (защита от «в ноль»)? — *по умолчанию: не ниже 0, но 100% скидку разрешаем только промокодом.*
- Нужен ли реферальный код / приветственные баллы новичку? — вне M9, отметить как расширение.

---

## 2. Карта интеграции в существующий код

Точки, которые придётся тронуть (все проверены на текущем коде):

- **`Application/Order/Command/PlaceOrder/`** — ядро расчёта. Сейчас: `Handler` суммирует
  `lineTotalKopecks()` по позициям → `Order::buildNew(totalKopecks: $total, ...)`.
  Станет: subtotal → `PromotionEngine::apply(...)` → списание баллов (`RedeemPoints`) →
  `payableTotal`. `Command` получит новые поля: `?string $promocode`, `?int $pointsToSpend`.
- **`Application/Order/Entity/Order/Order.php`** — добавить поля разбивки: `subtotalKopecks`,
  `discountKopecks`, `appliedDiscounts` (JSON: список применённых промо), `pointsSpent`,
  `pointsEarned`. `totalKopecks` остаётся **итог к оплате** (payable). `buildNew` расширяется.
- **`Infrastructure/Doctrine/Domain/Order/Order.php`** + миграция — те же колонки (JSON для `appliedDiscounts`).
- **`Application/Order/Query/OrderView.php`** — вернуть разбивку скидок/баллов в ответе.
- **`Application/Order/Command/RecordOrderPayment/Handler.php`** — после `registerPayment`
  финализировать резерв баллов (reserved → spent). Начисление — НЕ здесь (на `completed`).
- **`Application/Order/Command/ChangeOrderStatus/Handler.php`** — при переходе в `completed`
  триггерить `Loyalty\Command\AccrueOrderRewards` (начисление кэшбэка, апдейт lifetime/tier, штамп).
- **`Application/Order/Command/CancelOrder/Handler.php`** (+ `SyncOrderStatusFromPos` на отмену) —
  при отмене вернуть зарезервированные баллы (`ReleaseReservedPoints`) и откатить `PromotionRedemption`.
- **`OrderRepositoryInterface`** — добавить `countCompletedByCustomer(workspaceId, customerId): int`
  (для условия «только первый заказ» и для штампов) и `sumCompletedTotalByCustomer(...)` при необходимости.

**Порт для развязки Order↔Promotion/Loyalty.** Чтобы не тянуть домены друг в друга, ввести в
`Application/Order/Pricing/`:
- `OrderPricingInterface::price(PricingRequest): PricingResult` — реализуется в Promotion/Loyalty
  слое (адаптер `Application/Promotion/Service/OrderPricingService` или в Shared). PlaceOrder зовёт порт.
- `OrderRewardsInterface` с `reserveOnPlace(...)`, `finalizeOnPaid(...)`, `releaseOnCancel(...)`,
  `accrueOnCompleted(...)` — реализуется в Loyalty. Обработчики Order зовут порт (по образцу
  уже существующего `WaitTimeRecalculatorInterface`). **Так Order не зависит от Loyalty напрямую.**

---

## 3. Доменная модель

### 3.1 `Application/Promotion`

**Сущность `Promotion` (агрегат правила скидки/промокода):**
- `id`, `workspaceId`, `venueId` (nullable = все точки воркспейса), `name`
- `type: PromotionTypeEnum { Automatic, Promocode }` — automatic применяется сама; promocode требует ввода кода
- `code` (nullable; обязателен и уникален в рамках воркспейса при `Promocode`)
- `reward: RewardTypeEnum { Percent, FixedAmount }` + `rewardValue` (percent → базисные пункты; fixed → копейки)
- `target: PromotionTargetEnum { Order, Item, Category }` + `targetRefs` (JSON: список externalId позиций / id категорий; для Order пусто)
- `conditions` (VO `PromotionConditions`, хранится JSON): `minTotalKopecks?`, `orderTypes?` (list delivery/pickup),
  `daysOfWeek?` (1–7), `timeFrom?`/`timeTo?` (happy hours, HH:MM), `firstOrderOnly` (bool),
  `validFrom?`/`validTo?` (даты)
- `priority` (int, по убыванию), `stackable` (bool)
- лимиты: `maxRedemptions?` (всего), `maxRedemptionsPerCustomer?`, `redemptionsCount` (счётчик)
- `isActive` (bool)
- таймстемпы

**VO `PromotionConditions`** — метод `isSatisfiedBy(PromotionContext): bool` (чистая проверка).
`PromotionContext`: `customerId`, `orderType`, `now` (DateTimeImmutable), `subtotalKopecks`,
`isFirstOrder` (bool), `itemExternalIds`/`categoryIds` в корзине.

**Сущность-леджер `PromotionRedemption`:** `id`, `promotionId`, `workspaceId`, `orderId`, `customerId`,
`discountKopecks`, `createdAt`. Нужен для: лимитов per-customer/total, аудита, отката при отмене заказа.

**`Service/PromotionEngine`:**
- `apply(PromotionContext, ?string $promocode): PromotionResult`
- логика: собрать активные промо точки/воркспейса → отфильтровать `isSatisfiedBy` (+ промокод по коду
  и лимитам) → отсортировать по `priority` → применять по правилу стекинга (см. решение 3): идём по
  списку, суммируем скидки пока `stackable`; первый не-`stackable` — если он выгоднее накопленного,
  берём только его, иначе оставляем накопленное; останавливаемся. Считаем `discountKopecks` по `target`
  (order — от subtotal; item/category — от суммы подходящих строк).
- `PromotionResult`: `totalDiscountKopecks`, `appliedPromotions` (list: promotionId, name, discountKopecks).
- **Чистый сервис**, без БД внутри — данные подаёт вызывающий Handler/адаптер (репозиторий загружает список).

**Репозиторий `PromotionRepositoryInterface`:** `save`, `findById`, `findActiveByVenue(workspaceId, venueId)`,
`findByCode(workspaceId, code)`, `countRedemptionsByCustomer(promotionId, customerId)`, `saveRedemption`,
`deleteRedemptionByOrder(orderId)`.

**Use-cases (владелец):** `CreatePromotion`, `UpdatePromotion`, `ChangePromotionActivity`, `DeletePromotion`.
**Query:** `GetPromotions` (список по воркспейсу/точке), `GetPromotion`.

### 3.2 `Application/Loyalty`

**Конфиг `LoyaltyProgram` (один на воркспейс):** `id`, `workspaceId` (unique), `isEnabled`,
`earnRateBasisPoints` (% кэшбэка), `pointValueKopecks` (1 балл в копейках, дефолт 100),
`redeemMaxPercentBasisPoints` (лимит оплаты баллами от суммы заказа), `pointsLifetimeDays` (nullable),
`earnOnStatus` (enum paid/completed, дефолт completed), таймстемпы.

**`LoyaltyTier`:** `id`, `workspaceId`, `name`, `thresholdKopecks` (lifetime spend для уровня),
`earnRateBonusBasisPoints` (доп. кэшбэк), `permanentDiscountBasisPoints` (постоянная скидка уровня),
`sortOrder`. Уровень гостя = максимальный tier с `thresholdKopecks ≤ lifetimeSpentKopecks`.

**`LoyaltyAccount` (кошелёк гостя в воркспейсе):** `id`, `workspaceId`, `customerId`
(unique пара), `pointsBalance`, `reservedPoints`, `lifetimeSpentKopecks`, `currentTierId` (nullable),
таймстемпы. Инвариант: `pointsBalance ≥ 0`, доступно к трате = `pointsBalance - reservedPoints`.

**`LoyaltyTransaction` (леджер, только append):** `id`, `accountId`, `workspaceId`, `orderId` (nullable),
`type: LoyaltyTxTypeEnum { Earn, RedeemReserve, RedeemFinalize, RedeemRelease, Expire, ManualAdjust }`,
`points` (знаковое), `balanceAfter`, `createdAt`, `comment?`.

**Штампы `StampProgram` (конфиг):** `id`, `workspaceId`, `isEnabled`, `requiredCount`,
`rewardType`/`rewardValue` (напр. FreeItem externalId или Percent), `venueId?`.
**`StampProgress`:** `id`, `workspaceId`, `customerId`, `currentStamps`, `updatedAt` (сбрасывается после награды).

**Сервисы:**
- `Service/TierResolver::resolve(lifetimeSpentKopecks, tiers[]): ?LoyaltyTier` — чистый.
- `Service/RewardCalculator` — расчёт кэшбэка: `earnRate = program.earnRate + tier.earnRateBonus`;
  `points = round(base × earnRate / 10000 / pointValueKopecks)`, base = net paid (по умолчанию).

**Use-cases:**
- Владелец: `SetLoyaltyProgram`, `SetLoyaltyTiers` (замена набора), `SetStampProgram`,
  `AdjustLoyaltyBalance` (ручная коррекция баллов с комментарием — для поддержки).
- Системные (через порт `OrderRewardsInterface`): `ReserveRedeemPoints` (на PlaceOrder),
  `FinalizeRedeemPoints` (на paid), `ReleaseReservedPoints` (на cancel),
  `AccrueOrderRewards` (на completed: начислить кэшбэк, обновить lifetime, пересчитать tier, +штамп).
- Query (гость): `GetLoyaltyAccount` (баланс, уровень, прогресс до следующего), `GetLoyaltyHistory`.

**Репозитории:** `LoyaltyProgramRepositoryInterface`, `LoyaltyTierRepositoryInterface`,
`LoyaltyAccountRepositoryInterface` (`findByCustomer`, `getOrCreate`), `LoyaltyTransactionRepositoryInterface`,
`StampProgramRepositoryInterface`, `StampProgressRepositoryInterface`.

---

## 4. Конвейер расчёта заказа (единая точка истины)

Порядок в `PlaceOrder` (и в предпросмотре — см. 5.6):

```
subtotal            = Σ lineTotalKopecks                        (как сейчас)
promoResult         = PromotionEngine.apply(context, promocode)  // automatic + промокод + tier permanent discount
afterPromo          = subtotal − promoResult.totalDiscount
pointsDiscount      = min(pointsToSpend × pointValueKopecks,
                          afterPromo × redeemMaxPercent,
                          доступные баллы × pointValueKopecks)
payableTotal        = max(0, afterPromo − pointsDiscount)
pointsToEarn        = RewardCalculator (считается, начисляется позже на completed)
```

- **Tier permanent discount** — самое простое включить как «виртуальное» automatic-правило внутри
  `PromotionEngine` (движок получает tier гостя в контексте), чтобы стекинг был в одном месте.
- Все суммы фиксируются в `Order` снимком. Гость не может подменить цены/скидку — всё считается на сервере.
- Идемпотентность: резерв баллов и `PromotionRedemption` создаются в той же транзакции, что и заказ
  (см. долг M7 — транзакционный CreateWorkspace; здесь сразу делаем через `wrapInTransaction`/flush-барьер).

---

## 5. Под-этапы (вертикальные срезы). Порядок реализации

Каждый под-этап: уточнить открытые вопросы → доменная сущность+интерфейс → Doctrine+миграция →
Command/Handler и/или Query/Fetcher → Action → `lint:container` → отметка в этом файле.

### M9.1 — Promotion: скидки и промокоды на сумму заказа
- Сущность `Promotion` (оба типа), VO `PromotionConditions`, enum'ы, `PromotionRedemption`.
- `PromotionEngine` (стекинг по приоритету), пока `target = Order`.
- Doctrine + миграция (`promotion`, `promotion_redemption`).
- CRUD владельца: `CreatePromotion`/`UpdatePromotion`/`ChangePromotionActivity`/`DeletePromotion`, `GetPromotions`/`GetPromotion`.
- Порт `Order/Pricing/OrderPricingInterface` + адаптер; интеграция в `PlaceOrder` (поле `promocode`),
  запись `appliedDiscounts`/`discountKopecks`, откат `PromotionRedemption` в `CancelOrder`.
- Order-миграция: новые колонки (`subtotal_kopecks`, `discount_kopecks`, `applied_discounts` JSON).
- Actions: `POST/GET /api/v1/workspaces/{workspaceId}/promotions`, `GET/PUT/DELETE /api/v1/promotions/{promotionId}`,
  `POST /api/v1/promotions/{promotionId}/activation`.
- **Уточнить:** формат ввода промокода (регистр, пробелы); поведение при невалидном промокоде
  (ошибка 400 vs тихо игнор — по умолчанию 400 с кодом `PROMOCODE_INVALID`); можно ли 100% скидку.

### M9.2 — Promotion: таргетинг на позиции/категории + условия
- Расширить `target` на `Item`/`Category`, расчёт скидки по подходящим строкам заказа.
- Полный набор `conditions`: `minTotal`, `orderTypes`, `daysOfWeek`, happy hours, `firstOrderOnly`
  (через `OrderRepository::countCompletedByCustomer`), `validFrom/validTo`.
- **Уточнить:** как соотносить `targetRefs` с меню (externalId позиции / id категории Menu);
  что считается «первым заказом» (completed vs любой оплаченный).

> **Статус: реализовано (2026-07-09).** Согласовано: «первый заказ» = **у гостя нет ни одного оплаченного/активного заказа** (статусы paid…completed) в воркспейсе; happy-hours и дни недели считаются **по таймзоне точки**; фиксированная скидка на позицию/категорию применяется **один раз на заказ** (потолок — сумма подходящих строк).
>
> `PromotionTargetEnum` расширен `Item`/`Category`; `targetRefs` = список externalId позиций (Item) или категорий (Category) из модели Menu (`MenuItem.externalId`/`categoryExternalId`, `Category.externalId`). База скидки: Order → сумма заказа, Item/Category → сумма подходящих строк (`Promotion::discountBase`). `discountFor` теперь принимает `PromotionContext`. Полный `PromotionConditions` (min_total, order_types, **days_of_week 1–7**, **time_from/time_to happy-hours с окном через полночь**, **first_order_only**, valid_from/valid_to); расписание проверяется по локальному времени точки. В расчёт проброшены построчные данные и контекст: порт получил VO `PricingLine`, `OrderPricingRequest` — `timezone`/`isFirstOrder`/`lines`; `PromotionContext`/`CartLine` — их зеркала в домене Promotion. `OrderRepository::hasPaidOrBeyondByCustomer` питает `isFirstOrder`. `PlaceOrder` строит `PricingLine` (позиция+категория+сумма строки). Create/Update промо принимают `target`/`target_refs`; `PromotionView` их отдаёт.
>
> **Venue получил `timezone`** (решение «таймзона точки»): доменная/Doctrine сущность, `Create/UpdateVenue` (+Actions, дефолт `Europe/Moscow`, при update сохраняется текущее если не передано), `VenueView`, миграция `Version20260709130000` (валидация IANA в домене). Проверено: `lint:container` OK, `doctrine:mapping:info` OK (venue+promotion), `php -l` OK. **Пользователю: прогнать миграцию `Version20260709130000`.**
>
> **Осознанно отложено:** «первый заказ» смотрит на текущий статус (оплаченный‑затем‑отменённый заказ не засчитывается — гость снова «первый»); один промокод = один код на воркспейс (partial-unique), без разных кодов по точкам для одной акции.

### M9.3 — Loyalty: кошелёк баллов (кэшбэк) — начисление и списание
- `LoyaltyProgram` (конфиг), `LoyaltyAccount`, `LoyaltyTransaction`, `RewardCalculator`.
- Порт `Order/Rewards/OrderRewardsInterface` + адаптер в Loyalty:
  `ReserveRedeemPoints` (PlaceOrder, поле `pointsToSpend`), `FinalizeRedeemPoints` (RecordOrderPayment),
  `ReleaseReservedPoints` (CancelOrder), `AccrueOrderRewards` (ChangeOrderStatus→completed).
- Doctrine + миграция (`loyalty_program`, `loyalty_account`, `loyalty_transaction`).
- Order-миграция: `points_spent`, `points_earned`.
- Owner: `SetLoyaltyProgram`, `AdjustLoyaltyBalance`. Guest: `GetLoyaltyAccount`, `GetLoyaltyHistory`.
- Actions: `PUT /api/v1/workspaces/{workspaceId}/loyalty/program`, `GET /api/v1/loyalty/account?workspaceId=`,
  `GET /api/v1/loyalty/history`, `POST /api/v1/workspaces/{workspaceId}/loyalty/adjust`.
- **Уточнить:** курс балла, база начисления, момент начисления, лимит оплаты баллами, округление.
  Конкурентность: резерв уменьшает доступное сразу (защита от двойной траты) — подтвердить.

> **Статус: реализовано (2026-07-10).** Согласовано: **1 балл = 1 рубль** (pointValueKopecks=100); начисление **от оплаченной суммы (net paid = order.totalKopecks)**; **в момент completed**; округление **вниз (floor)**.
>
> Домен `Application/Loyalty`: `LoyaltyProgram` (конфиг воркспейса + формулы `earnPointsFor`/`redeemablePoints`, лимит оплаты баллами `redeemMaxPercentBasisPoints`, дефолт 50%, потолок MIN_PAYABLE=100 внутри); `LoyaltyAccount` (pointsBalance/reservedPoints + reserve/finalize/release/refund/earn/adjust, доступно=balance−reserved); `LoyaltyRedemption` (жизненный цикл списания по заказу: reserved→finalized→released/refunded, уникальность по order_id); `LoyaltyTransaction` (append-леджер начислений/списаний/возвратов/корректировок для истории). Адаптер `Service/OrderRewards` реализует порт.
>
> **Порт `Application/Order/Rewards/OrderRewardsInterface`** (+ `RedeemQuoteRequest`/`RedeemQuoteResult`): `quoteRedeem` (расчёт списания без записи), `reserveOnPlace`, `finalizeOnPaid`, `releaseOnCancel`, `accrueOnCompleted`→int. Alias в services.yaml. Конвейер в `PlaceOrder`: subtotal → промо → **списание баллов поверх** (`points_to_spend`) → payable; резерв после save. `RecordOrderPayment`→finalize; `CancelOrder`/`ChangeOrderStatus→canceled`/`SyncFromPos→canceled`→release/refund (+ откат промо во всех путях отмены — **починка пробела M9.1**, где revert был только в гостевом CancelOrder); `ChangeOrderStatus`/`SyncFromPos`→completed→accrue (идемпотентно через `existsEarnForOrder`) + `Order::recordEarnedPoints`.
>
> Order получил `pointsSpent`/`pointsEarned` (миграция `Version20260709140000` + 4 таблицы loyalty); `buildNew` вычитает points-discount; `OrderView` отдаёт `points_spent`/`points_earned`/`points_discount_kopecks`. Owner: `SetLoyaltyProgram` (upsert), `AdjustLoyaltyBalance`. Guest: `GetLoyaltyAccount`, `GetLoyaltyHistory`. Actions: PUT `/workspaces/{id}/loyalty/program`, POST `/workspaces/{id}/loyalty/adjust`, GET `/loyalty/account?workspace_id=`, GET `/loyalty/history?workspace_id=&limit=`. Проверено: `lint:container` OK, `debug:router` (4 роута), `doctrine:mapping:info` OK (4 сущности), `php -l` OK. **Пользователю: прогнать миграцию `Version20260709140000`.**
>
> **Осознанно отложено:** сгорание баллов (`pointsLifetimeDays` хранится, но крон-экспирации нет) — позже; конкурентность резерва — окно между quote и reserve не заблокировано (как и не-транзакционность промо, общий долг M7); `earnOnStatus` не вынесен в конфиг (зафиксирован completed); lifetime/tier — M9.4.

### M9.4 — Loyalty: уровни (tiers) по lifetime spend
- `LoyaltyTier`, `TierResolver`, поле `lifetimeSpentKopecks`/`currentTierId` в `LoyaltyAccount`.
- `AccrueOrderRewards` инкрементит lifetime и пересчитывает tier; tier даёт `permanentDiscount`
  (входит в `PromotionEngine` как виртуальное правило) и `earnRateBonus`.
- Owner: `SetLoyaltyTiers` (замена набора). Отразить уровень/прогресс в `GetLoyaltyAccount`.
- Миграция (`loyalty_tier` + колонки account).
- **Уточнить:** пороги уровней; что делать с уже накопленным lifetime при первом включении программы
  (считать с нуля vs backfill по истории заказов — по умолчанию с нуля).

### M9.5 — Loyalty: штампы (stamp-card)
- `StampProgram` (конфиг), `StampProgress`, продвижение в `AccrueOrderRewards`, выдача награды при `requiredCount`.
- Owner: `SetStampProgram`. Guest: прогресс в `GetLoyaltyAccount`.
- Миграция (`stamp_program`, `stamp_progress`).
- **Уточнить:** что считается «штампом» (любой completed заказ / заказ выше минимальной суммы);
  вид награды (бесплатная позиция vs скидка vs баллы); сброс прогресса после награды.

### M9.6 — Витрина гостю + админка + метрики
- Предпросмотр цены до оформления: `POST /api/v1/venues/{venueId}/orders/quote` — принимает корзину +
  `promocode` + `pointsToSpend`, возвращает разбивку (subtotal/скидки/баллы/итог) **без создания заказа**
  (общий `Order/Pricing` сервис, чтобы расчёт совпадал 1:1 с `PlaceOrder`).
- Отразить разбивку в `OrderView` (skidki, applied_discounts, points_spent/earned).
- EasyAdmin: read-only разделы Promotion / LoyaltyProgram / LoyaltyTier / LoyaltyTransaction / StampProgram;
  метрики в `MetricsReader` (сумма выданных скидок, потраченные/начисленные баллы, топ промокодов).
- Аудит: добавить новые сущности в whitelist `AuditSubscriber`.
- **Уточнить:** нужен ли отдельный публичный эндпоинт списка активных акций для гостя (витрина промо).

---

## 6. Нефункциональные требования и риски

- **Транзакционность.** Заказ + `PromotionRedemption` + резерв баллов должны создаваться атомарно.
  Учесть общий долг из `PLAN.md` M7 (не-транзакционный CreateWorkspace) — здесь сразу оборачивать в транзакцию.
- **Идемпотентность.** `AccrueOrderRewards` вызывается на переходе в `completed` — защититься от повторного
  начисления (флаг `rewardsAccrued` на заказе или проверка наличия `Earn`-транзакции по `orderId`).
- **Конкурентность баллов.** Списание через резерв (`reservedPoints`), пессимистичная/оптимистичная
  блокировка `LoyaltyAccount` при трате; не допускать `pointsBalance - reservedPoints < 0`.
- **Лимиты промокодов** (`maxRedemptions`, per-customer) проверять под блокировкой/через уникальный индекс
  на `promotion_redemption(promotion_id, order_id)` и счётчик.
- **Мультитенантность.** Все таблицы с `workspace_id` + индексом; репозитории фильтруют.
- **Тесты (см. долг M7).** Unit на `PromotionEngine` (стекинг, target, conditions), `TierResolver`,
  `RewardCalculator`; функциональные на `PlaceOrder` со скидкой/промокодом/баллами и на откат при отмене.
- **Деньги/проценты** только `int` (копейки / базисные пункты). Округление баллов задокументировать в `RewardCalculator`.
- **Наблюдаемость.** Логировать применение промо и движения баллов (`LoggerService::toFile('promotion/apply', ...)`,
  `'loyalty/accrue'`).

---

## 7. Definition of Done (на каждый под-этап M9.x)
- [ ] Открытые вопросы под-этапа закрыты (заданы уточняющие вопросы).
- [ ] Доменная сущность + `RepositoryInterface` в `Application` (без Doctrine), enum'ы/VO.
- [ ] Doctrine-сущность + репозиторий в `Infrastructure` + миграция (workspace_id + индекс).
- [ ] Command/Handler и/или Query/Fetcher, именованные аргументы, `\DomainException` на русском.
- [ ] Action(ы) с `ApiResponse`, права через `WorkspaceAccess`, ошибки → 400.
- [ ] Интеграция в `Order` (если этап её касается) через порт, снимок сумм в заказе.
- [ ] `php bin/console lint:container` → OK; ключевые unit-тесты.
- [ ] Обновлён статус в этом файле (что решено/сделано/осознанно отложено) и авто-память.

---

## 8. Журнал статусов (заполнять по мере реализации)
- **2026-07-09** — план составлен, ключевые архитектурные решения зафиксированы (раздел 1). Реализация не начата.
- **2026-07-09 — M9.1 реализовано.** Согласовано: невалидный/неподходящий промокод → 400 (сообщение, заказ не создаётся); 100%-скидку не допускаем — итог не ниже `PromotionEngine::MIN_PAYABLE_KOPECKS` (100 коп, потолок скидки в самом движке, при необходимости вынести в настройку); промокод нормализуется `UPPER+trim` и так хранится.
  - **Домен `Application/Promotion`:** сущность `Promotion` (типы Automatic/Promocode, reward Percent(б.п.)/FixedAmount(коп), target пока только `Order`), VO `PromotionConditions` (M9.1-подмножество: `min_total_kopecks`, `order_types`, `valid_from`, `valid_to`), `PromotionContext`/`PromotionResult`/`AppliedPromotion`, леджер `PromotionRedemption`, `PromotionRepositoryInterface`. Чистый `Service/PromotionEngine` (стекинг по priority + stackable, эксклюзив завершает подбор, потолок скидки). Адаптер `Service/PromotionPricing` реализует порт Order, валидирует промокод/лимиты (общий и на гостя), пишет/откатывает применения.
  - **Порт развязки в Order:** `Application/Order/Pricing/OrderPricingInterface` (+ `OrderPricingRequest`/`OrderPricingResult`/`AppliedDiscount`). Реализация — `PromotionPricing`, alias в `services.yaml`.
  - **CRUD владельца:** Create/Update/ChangeActivity/Delete + запросы GetPromotions/GetPromotion (`PromotionView`). Actions: POST/GET `/api/v1/workspaces/{workspaceId}/promotions`, GET/PUT/DELETE `/api/v1/promotions/{promotionId}`, POST `/api/v1/promotions/{promotionId}/activation`. Права владельца — `WorkspaceAccess`.
  - **Интеграция в заказ:** `Order` (доменный + Doctrine) получил `subtotalKopecks`/`discountKopecks`/`appliedDiscounts` (JSON), `totalKopecks` = payable; `buildNew` считает payable = max(0, subtotal−discount). `PlaceOrder` (поле `promocode`) считает subtotal → `priceOrder` → payable, после save зовёт `recordApplied`. `CancelOrder` зовёт `revertApplied`. `OrderView` отдаёт разбивку. Doctrine `OrderRepository` маппит новые поля.
  - **Doctrine/миграция:** `Infrastructure/Doctrine/Domain/Promotion/{Promotion,PromotionRedemption,PromotionRepository}` (partial-unique индекс на `(workspace_id, code) WHERE code IS NOT NULL`, unique `(promotion_id, order_id)`). Миграция `Version20260709120000` (2 таблицы + 3 колонки в `"order"` + backfill `subtotal_kopecks = total_kopecks`). **Пользователю: прогнать `doctrine:migrations:migrate`.**
  - Проверено: `lint:container` OK, `debug:router` (6 роутов), `doctrine:mapping:info` OK, `php -l` OK.
  - **Осознанно отложено:** target `Item`/`Category` и полный набор условий (days/happy-hours/firstOrderOnly) — M9.2; откат применений при отмене из POS-синхронизации (`SyncOrderStatusFromPos`) — сделан только для явного `CancelOrder`; транзакционность (заказ + redemption + счётчики идут отдельными flush) — общий долг M7; аудит/метрики/quote-предпросмотр — M9.6. Машинный код ошибки `PROMOCODE_INVALID` не проставляется (доменное исключение только с сообщением — в духе текущих Action).
