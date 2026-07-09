# План разработки бэкенда: Агрегатор доставки еды для ресторанов

Backend на **Symfony 8.1 / PHP 8.4 / PostgreSQL 16 / Doctrine ORM 3**, по правилам из [`architecture.md`](./architecture.md) (DDD, порты и адаптеры, Command/Handler + Query/Fetcher).

Пока делаем **только бэкенд**. Приложение проектируется как основа будущей экосистемы, поэтому домены держим изолированными и расширяемыми.

---

## 0. Принцип работы над проектом (читать первым)

> **Постоянно задавай дотошные уточняющие вопросы.**
> Прежде чем писать любой новый use-case, сущность или интеграцию — уточняем детали у заказчика, а не додумываем. Цель: с первого раза писать **корректный и понятный человеку** функционал, без переделок.

Правила процесса:

1. **Одно неясное место = один вопрос.** Не начинаем кодить домен, пока не сняты неоднозначности бизнес-логики (статусы, переходы, кто владелец данных, что происходит в пограничных случаях).
2. **Формула, деньги, статусы, права доступа — всегда уточняем явно.** Здесь цена ошибки максимальна (особенно «умная формула времени ожидания» и биллинг).
3. **Показываем контракт до реализации.** Для нового Action согласовываем формат запроса/ответа (поля, коды ошибок) до написания Handler'а.
4. **Имена — по-человечески.** Никаких `ensure`, `resolve`, `process`, безликих `Manager`/`Data`. Имя объясняет намерение: `estimateWaitTime`, `markOrderReady`, `findVenueBySlug`. Код читается линейно сверху вниз.
5. **Маленькими вертикальными срезами.** Каждый шаг — законченный вертикальный срез (Entity → Repository → Command/Query → Action), который можно проверить.
6. **Не ломаем существующее.** `Authorize`, `Tarif`, `Workspace` уже начаты — новые домены строим в их стиле, старое приводим к гайдлайну аккуратно.

### Открытые вопросы, которые надо закрыть по ходу (живой список)

**Закрыто (M0, 2026-07-07):**
- [x] **Дубль пользователя.** Канонический пользователь — домен `Authorize` (аутентификация + профиль). Сломанный `Application/Users` удалён; `SetSubscribeOnTarif` переедет в домен `Subscription`.
- [x] **Роли/владение.** Отдельная сущность `Membership` (user↔workspace с ролью `owner|staff`). Право владельца = активная подписка.
- [x] **Резолв воркспейса.** По поддомену `slug.app.com`; в dev — fallback через заголовок `X-Workspace-Slug` (только при `kernel.debug`).

**Осталось уточнить:**
- [ ] **Что именно рассчитывает «умная формула» времени ожидания** и по каким входным данным (см. раздел 9). — **уточнить до реализации.**
- [ ] **CloudPayments**: подписки владельцев (рекуррент) и/или оплата заказов гостями — оба сценария или только один на старте? — **уточнить.**
- [ ] **Гость vs пользователь заказа**: заказ только для авторизованных, или гостевой заказ по телефону? — **уточнить.**

---

## 1. Что уже есть (отправная точка)

- **`Authorize`** — регистрация/вход по телефону + SMS-код, JWT (access/refresh), logout, refresh. Actions под `/api/v1/auth`. Считаем регистрацию в основном готовой.
- **`Tarif`** — сущность тарифа (`TarifCodeEnum: basic|pro|enterprise`, `FeatureCodeEnum`), репозиторий, `GetAllTarif`-фетчер.
- **`Users/Command/SetSubscribeOnTarif`** — заготовка подписки пользователя на тариф (не дописана).
- **`Workspace`** — доменная сущность + интерфейс репозитория (реализации ещё нет).
- **Инфраструктура**: Doctrine (PostgreSQL 16), Messenger (`async` transport готов), Mercure, Monolog, JWT-firewall, CORS, `LoggerService`, `SMSManager`, `JWTManager`.
- **`libs/`**: сгенерированные SDK `IIKO` и `YOOMONEY`. **По решению — платежи на CloudPayments**, YooMoney-обвязку не используем (позже удалить/заигнорить).

---

## 2. Целевой бизнес-флоу

1. **Гость регистрируется** → становится пользователем (готово).
2. **Пользователь оформляет подписку** (CloudPayments) → **становится владельцем**.
3. Владелец **создаёт воркспейс** (`slug.app.com`).
4. Внутри воркспейса **добавляет точки** (кафе/рестораны).
5. Для точки **выбирает POS-систему** (iiko / rkeeper / …) и подключает её.
6. **Импортирует меню** из POS (фоново, через Messenger).
7. Публикуется **витрина воркспейса**: гости регистрируются и **заказывают еду**.
8. **Киллер-фича**: динамически пересчитываемое **примерное время ожидания** по умной формуле.

---

## 3. Карта доменов (целевая)

Нейминг — английский, доменный. Каждый домен по структуре из `architecture.md`.

| Домен | Ответственность | Ключевые сущности |
|---|---|---|
| `Authorize` | Аутентификация, токены, SMS-код | `User`, `Code`, `Token` (есть) |
| `Users` | Профиль пользователя, роль/владение | `User` (профиль), `Membership`? |
| `Subscription` | Подписка владельца на тариф, статус, рекуррент | `Subscription`, `Tarif` (есть) |
| `Billing` | Платежи и webhooks CloudPayments (порт `PaymentGatewayInterface`) | `Payment`, `Transaction` |
| `Workspace` | Воркспейс арендатора (`slug`), владелец | `Workspace` (есть) |
| `Venue` | Точки (кафе/рестораны) внутри воркспейса | `Venue`, расписание работы |
| `PosIntegration` | Подключение POS к точке (iiko/rkeeper), учётки, порт `PosMenuProviderInterface` | `PosConnection` |
| `Menu` | Меню/категории/позиции/модификаторы, импорт из POS | `MenuItem`, `Category`, `Modifier` |
| `Order` | Корзина, оформление, статусы, оплата | `Order`, `OrderItem` |
| `WaitTime` | Расчёт примерного времени ожидания (сервис + история) | `WaitTimeEstimate` |

Общие вещи — в `src/Shared` (enum'ы, VO вроде `ImageValueObject`, `Money` при необходимости).

---

## 4. Сквозные подсистемы (делаем в начале — на них опираются домены)

### 4.1 Контекст воркспейса (мультитенантность: одна БД + `workspace_id`)
- Резолвер текущего воркспейса в HTTP-слое (подписчик запроса): по поддомену `slug.app.com` → `workspaceId`, кладём в контекст запроса.
- В Command/Query передаём `workspaceId` **явным параметром** (не через глобальное состояние).
- Все тенант-репозитории **обязаны** фильтровать по `workspace_id`.
- **Вопрос:** резолв строго по поддомену или на старте по заголовку `X-Workspace`? — уточнить.

### 4.2 Единый формат ответа и ошибок
- Ответы: `{ is_success: bool, ... }`; ошибки: `{ is_success: false, error, code? }` (как в `SignUpAction`).
- Зафиксировать словарь машинных кодов ошибок (`USER_EXIST`, `WORKSPACE_SLUG_TAKEN`, `SUBSCRIPTION_REQUIRED`, …).

### 4.3 Money / деньги
- Хранить суммы в **копейках (int)**, как в `Tarif::price`. Ввести VO `Money` только если появятся операции с валютой/округлением. — уточнить необходимость.

### 4.4 Порты внешних систем
- `Billing\...\PaymentGatewayInterface` (адаптер CloudPayments в `Infrastructure`).
- `PosIntegration\...\PosMenuProviderInterface` (адаптеры iiko/rkeeper).

---

## 5. Домен `Subscription` + `Billing` (владелец платит и становится владельцем)

> **Статус: реализовано (M1, 2026-07-08).** Решения: рекуррент CloudPayments; статусы `pending/active/past_due/canceled`; без триала и грейса; в M1 только подписки владельцев (оплата заказов — M5 через тот же `PaymentGatewayInterface`). Право владельца = активная подписка (`Subscription::isActive()`), отдельного флага нет.
>
> **Сделано:** домен `Subscription` (сущность с доменными методами `registerPayment/markPastDue/cancel`, `SubscriptionStatusEnum`, порт репозитория); команды `StartSubscription`, `RecordSubscriptionPayment`, `MarkSubscriptionPastDue`, `StopSubscription`, `CancelSubscription`; запрос `GetCurrentSubscription`; порт `Billing\Gateway\PaymentGatewayInterface` + адаптер `Infrastructure\CloudPayments\CloudPaymentsGateway` (HMAC-проверка webhook, отмена подписки через API); Doctrine-сущность + репозиторий + миграция `Version20260708120000`; Actions `StartSubscriptionAction` (POST `/api/v1/subscriptions`), `GetSubscriptionAction` (GET `/api/v1/subscriptions/current`), публичный `CloudPaymentsWebhookAction` (POST `/api/v1/webhooks/cloudpayments/{type}` — `pay`/`fail`/`recurrent`); firewall `webhooks` в security.yaml. Попутно починен `TarifRepository::getByTarifCode` (был latent fatal — метод интерфейса не реализован).
>
> **CloudPayments-флоу (подтверждено):** рекуррентную подписку создаёт фронтенд-виджет (передаёт `recurrent`-параметры при первом платеже и токенизирует карту). Бэкенд не вызывает `subscriptions/create` — он только реагирует на webhooks (`pay`/`fail`/`recurrent`) и умеет отменять подписку через API.
>
> **Отложено в M2:** колонки лимитов на `Tarif` (`maxWorkspaces`, `maxVenues`) — добавлю вместе с их проверкой в `CreateWorkspace`/`CreateVenue`, чтобы не менять `Tarif` вхолостую.
>
> **Проверить после `composer install`:** `php bin/console lint:container`, затем `php bin/console doctrine:migrations:migrate`.

**Цель шага:** пользователь оформляет подписку через CloudPayments и получает право создавать воркспейсы.

**Уточнить до старта:**
- Рекуррентные списания или разовая оплата периода? Триал? Грейс-период при неоплате?
- Что даёт подписка технически: роль `owner`, лимиты по тарифу (число воркспейсов/точек)?
- Оплата заказов гостями — этот же `Billing` или отдельный контур?

**Задачи:**
1. `Subscription` (Application): сущность (`userId`, `tarifId`, `status`, `periodStart/End`, `provider`), `SubscriptionRepositoryInterface`, `SubscriptionStatusEnum` (`pending|active|past_due|canceled`).
2. Doctrine-сущность + репозиторий в `Infrastructure`, миграция.
3. `Billing`: `PaymentGatewayInterface` (порт) + адаптер CloudPayments (создание платежа/подписки, проверка подписи webhook).
4. Command/Handler:
   - `StartSubscription` — создаёт `pending`-подписку и платёж в CloudPayments, возвращает данные для виджета.
   - `ActivateSubscription` — по успешному webhook переводит в `active`, назначает роль владельца.
   - `CancelSubscription`.
5. Query/Fetcher: `GetCurrentSubscription`.
6. Actions: `StartSubscriptionAction`, `CloudPaymentsWebhookAction` (публичный, с проверкой подписи), `GetSubscriptionAction`.
7. Доработать `Users/Command/SetSubscribeOnTarif` под итоговую модель (или заменить на `Subscription`).

---

## 6. Домен `Workspace` (создание арендатора)

> **Статус: реализовано (M2, 2026-07-08).** Решения: slug строгий и неизменяемый (3–63, `[a-z0-9-]`, без крайних дефисов, резерв-лист); логотип nullable при создании; `Membership` (owner + staff) с добавлением/удалением сотрудников; лимит — 1 воркспейс на всех тарифах.
>
> **Сделано:** переписаны доменная сущность `Workspace` (nullable `id`/`logo`, `buildNew`, доменные методы `rename`/`attachLogo`) и `WorkspaceRepositoryInterface` (`save`/`findById`/`findBySlug`/`findAllByIds`/`countByOwner`); домен `Membership` (`MembershipRoleEnum` owner/staff, порт); сервис `WorkspaceSlugRule` (формат + резерв-лист); политика `Tarif\Service\TarifLimits` (лимит воркспейсов по тарифу, сейчас 1); команды `CreateWorkspace` (проверка активной подписки → лимит тарифа → формат slug → уникальность → создание воркспейса + owner-membership), `AddStaffMember` (по телефону зарегистрированного пользователя), `RemoveStaffMember` (владельца удалить нельзя); запрос `GetMyWorkspaces` (воркспейсы по членству + роль); Doctrine-сущности `Workspace` (logo как nullable JSON) и `Membership` + репозитории + миграция `Version20260708130000`; Actions POST/GET `/api/v1/workspaces`, POST `/api/v1/workspaces/{workspaceId}/staff`, DELETE `/api/v1/workspaces/{workspaceId}/staff/{staffUserId}`. Коды ошибок: `SUBSCRIPTION_REQUIRED`, `WORKSPACE_LIMIT_REACHED`, `WORKSPACE_SLUG_TAKEN`.
>
> **Находка:** таблицы `tarif` нет ни в одной миграции (Doctrine-сущность есть, миграции нет) — поэтому лимиты сделаны политикой в коде, а не колонкой БД. Когда у `tarif` появится миграция — лимиты можно перенести в БД.
>
> **Известное ограничение:** `CreateWorkspace` сохраняет воркспейс и owner-membership двумя отдельными `flush` (репозитории флашат сами). Теоретически возможен «осиротевший» воркспейс, если второй save упадёт. Транзакционную обёртку добавить при ужесточении (M7).
>
> **Не вошло (осознанно):** публичный `GetWorkspaceBySlug` для витрины и enrichment `WorkspaceContext` (slug→id) на каждый запрос — понадобятся для сторефронта, сделаю в M6. Загрузка логотипа — отдельным use-case позже.

**Цель:** владелец создаёт воркспейс со `slug`.

**Уточнить:** правила `slug` (латиница/длина/резерв слов); лимит воркспейсов по тарифу; можно ли менять `slug`.

**Задачи:**
1. Реализовать `WorkspaceRepository` (Doctrine) под существующий `WorkspaceRepositoryInterface` + Doctrine-сущность + миграция. Уникальный индекс на `slug`.
2. Command/Handler:
   - `CreateWorkspace` — проверяет право (активная подписка), уникальность `slug`, лимит тарифа; при занятом `slug` → `\DomainException('Slug уже занят')` / код `WORKSPACE_SLUG_TAKEN`.
   - `UpdateWorkspace`, `DeleteWorkspace`.
3. Query/Fetcher: `GetWorkspaceBySlug`, `GetMyWorkspaces`.
4. Actions: `CreateWorkspaceAction`, `UpdateWorkspaceAction`, `GetWorkspaceAction`, `GetMyWorkspacesAction`.

---

## 7. Домен `Venue` (точки внутри воркспейса)

> **Статус: реализовано (M3, 2026-07-08).** Решения: точку создаёт/меняет только владелец воркспейса; поля — адрес, гео (lat/lng), телефон, часы работы (недельное расписание), самовывоз + доставка с радиусом, флаг активности. Просмотр — любому участнику воркспейса (owner/staff).
>
> **Сделано:** доменная сущность `Venue` (доменные методы `updateDetails`/`setWorkingHours`/`changeActivity`), VO `WorkingHours` + `DaySchedule`, правило `WorkingHoursRule` (weekday 1–7 без повторов, время HH:MM, открытие < закрытия); порт `VenueRepositoryInterface`; сервис доступа `Workspace\Service\WorkspaceAccess` (`getOwnedWorkspace` для мутаций, `requireMember` для чтения — переиспользуется хендлерами Venue); команды `CreateVenue`, `UpdateVenue`, `SetVenueWorkingHours`, `ChangeVenueActivity`; запросы `GetVenuesByWorkspace`, `GetVenue` (общий read-model `VenueView`); Doctrine-сущность `Venue` (working_hours как JSON) + репозиторий + миграция `Version20260708140000`; Actions: POST/GET `/api/v1/workspaces/{workspaceId}/venues`, GET/PUT `/api/v1/venues/{venueId}`, PUT `/api/v1/venues/{venueId}/working-hours`, POST `/api/v1/venues/{venueId}/activation`.
>
> **Семантика:** `PUT /venues/{venueId}` — полная замена основных данных (кроме часов и активности, у них свои эндпоинты); фронтенд шлёт полный объект. Часы работы и активность — отдельными use-case'ами.
>
> **Упрощения (осознанно):** зоны доставки — радиусом (`delivery_radius_meters`), полигоны позже; часы работы — простое недельное расписание без спец-дней/перерывов; валидности гео (диапазоны координат) не проверяем.

**Цель:** владелец добавляет кафе/рестораны в воркспейс.

**Уточнить:** набор полей точки (адрес, гео-координаты, часы работы, зоны/радиус доставки, самовывоз?), может ли точка быть в нескольких воркспейсах (нет по умолчанию).

**Задачи:**
1. `Venue` (Application): `workspaceId`, `name`, `address`, гео, расписание, `isActive`; `VenueRepositoryInterface` (фильтр по `workspaceId`).
2. Doctrine-сущность + репозиторий + миграция (`workspace_id`, индекс).
3. Command/Handler: `CreateVenue`, `UpdateVenue`, `SetVenueWorkingHours`, `ActivateVenue`/`DeactivateVenue`.
4. Query/Fetcher: `GetVenuesByWorkspace`, `GetVenue`.
5. Actions: CRUD + список.

---

## 8. Домены `PosIntegration` и `Menu` (подключение POS и импорт меню)

> **Статус: реализовано (M4, 2026-07-08).** Решения: меню с модификаторами; исчезнувшие позиции **архивируются** (не удаляются); секреты POS **шифруются** (libsodium); адаптер iiko — на **сгенерированном клиенте** `IIKO\`.
>
> **Сделано.** `PosIntegration`: `PosConnection` (enum'ы `PosSystemEnum`/`PosConnectionStatusEnum`, доменные методы `reconfigure`/`markSynced`/`markFailed`), порт `PosMenuProviderInterface` + нормализованный снапшот (`PosMenuSnapshot`/`PosCategory`/`PosItem`/`PosModifierGroup`/`PosModifier`), `PosMenuProviderRegistry` (выбор адаптера по системе, tagged_iterator), порт очереди `MenuImportQueueInterface`; команды `ConnectPos` (владелец-only, реконфиг при повторе), `RequestMenuImport` (кладёт в очередь), `ImportMenu` (оркестрация: провайдер → импортёр → статус, try-catch для отметки ошибки и ретрая). `Menu`: сущности `Category`/`MenuItem`/`ModifierGroup`/`Modifier` (externalId, isArchived, доменные `applyFromPos`/`archive`), сервис `MenuImporter` (upsert по externalId + архивирование отсутствующих), запрос `GetMenu` (дерево категория→позиции→модификаторы, доступ участнику). Инфраструктура: `SecretCipher` (Shared, sodium secretbox), 5 Doctrine-сущностей + репозиториев (PosConnectionRepository шифрует/дешифрует apiLogin), адаптер `Iiko\IikoMenuProvider` (auth → api2MenuByIdPost → маппинг; все геттеры клиента сверены), Messenger (`ImportMenuMessage` + `#[AsMessageHandler]` + адаптер очереди `MenuImportQueue`), миграция `Version20260708150000` (5 таблиц). Actions: POST `/api/v1/venues/{venueId}/pos`, POST `/api/v1/venues/{venueId}/pos/import` (202), GET `/api/v1/venues/{venueId}/menu`. Env: `APP_POS_SECRET_KEY`, `IIKO_API_URL`; messenger routing `ImportMenuMessage → async`.
>
> **Требует внимания:** (1) маппинг `IikoMenuProvider` составлен по схеме клиента и **должен быть проверен на реальном ответе iiko** (цены/модификаторы лежат внутри размеров позиции; берём первый размер); (2) `APP_POS_SECRET_KEY` в .env — DEV-заглушка (нули), заменить в проде; (3) каждый `save` в `MenuImporter` — отдельный flush (для больших меню медленно; батчинг/транзакция — в M7); rkeeper-адаптер — позже.

**Цель:** для точки выбирается POS-система, подключается, из неё **фоново** импортируется меню.

**Уточнить:** какие поля учётки нужны для iiko/rkeeper (apiLogin/organizationId/terminalGroup и т.п.); как хранить секреты (шифрование в БД / секрет-хранилище); частота ресинка; поведение при расхождении (upsert по внешнему id, что делать с исчезнувшими позициями — архивировать?).

### 8.1 `PosIntegration`
1. `PosConnection` (Application): `venueId`, `PosSystemEnum` (`iiko|rkeeper`), учётные данные, `status` (`connected|error`), `lastSyncedAt`; `PosConnectionRepositoryInterface`.
2. Порт `PosMenuProviderInterface { fetchMenu(PosConnection): PosMenuData }`.
3. Адаптеры в `Infrastructure`: `IikoMenuProvider` (использует `libs/IIKO`), `RkeeperMenuProvider` (позже). Выбор адаптера — по `PosSystemEnum`.
4. Command/Handler: `ConnectPos`, `TestPosConnection`, `RequestMenuImport` (кладёт `ImportMenuMessage` в Messenger `async`).
5. Actions: подключить POS, проверить соединение, запустить импорт.

### 8.2 `Menu`
1. Сущности: `Category`, `MenuItem` (цена в копейках, доступность, стоп-лист), `Modifier`/`ModifierGroup`; внешний id из POS (`externalId`) для идемпотентного upsert. Всё скоуп-нуто по `workspaceId`/`venueId`.
2. Doctrine-сущности + репозитории + миграции.
3. Messenger: `ImportMenuMessage` + `#[AsMessageHandler] ImportMenuMessageHandler` → вызывает `PosMenuProvider`, мэппит `PosMenuData` в доменные сущности, делает upsert, ставит `lastSyncedAt`.
4. Query/Fetcher: `GetMenu` (витрина для гостей), `GetMenuForOwner` (управление, стоп-листы).
5. Actions: получить меню точки, ручной запуск ресинка, управление доступностью позиций.

---

## 9. Домен `Order` + `WaitTime` (заказ и киллер-фича)

### 9.1 `Order`
**Уточнить:** гостевой заказ или только авторизованный; типы (доставка/самовывоз); оплата онлайн (CloudPayments) или при получении; набор статусов и **кто** их меняет (владелец/точка/POS/автоматически); отмена и возвраты.

**Задачи:**
1. `Order` (Application): `workspaceId`, `venueId`, `customerId`, позиции (`OrderItem`: `menuItemId`, `qty`, цена на момент заказа), `total`, `type`, `OrderStatusEnum` (черновой: `created|paid|accepted|cooking|ready|on_the_way|completed|canceled`), `estimatedWaitMinutes`, таймстемпы переходов.
2. Doctrine-сущности + репозитории + миграции.
3. Command/Handler: `PlaceOrder` (проверка доступности позиций/стоп-листа, расчёт суммы, создание платежа при онлайн-оплате), `PayOrder`/webhook, `ChangeOrderStatus`, `CancelOrder`.
4. Query/Fetcher: `GetOrder`, `GetMyOrders`, `GetVenueOrders` (для точки).
5. Уведомления о смене статуса — через Messenger/Mercure (реалтайм гостю). — уточнить каналы.

> **Статус: реализовано (M5, 2026-07-08).** Согласованные решения: заказ оформляет **только авторизованный** пользователь (`customerId` = userId из JWT, контакты — имя/телефон/адрес хранятся в заказе снимком); оплата — **только онлайн CloudPayments** (первый платёж виджетом, подтверждение webhook'ом, через тот же `PaymentGatewayInterface`); статусы двигает **персонал вручную** + заложен вход для **авто-синхронизации из POS**; реалтайм — **Mercure сейчас**.
>
> Домен `Application/Order`: сущность `Order` (агрегат с явной картой переходов `allowedNextStatuses`, история переходов с источником `OrderStatusSourceEnum` customer/staff/pos/system, `estimatedWaitMinutes` зарезервирован под M6), VO `OrderItem`/`OrderItemModifier` (снимок цен, `lineTotalKopecks`), enum'ы `OrderStatusEnum` (created/paid/accepted/cooking/ready/on_the_way/completed/canceled) и `OrderTypeEnum` (delivery/pickup). Команды: `PlaceOrder` (цены берутся из активного меню по `externalId`, сумма считается на сервере, валидируется тип/адрес/доступность позиций и принадлежность модификаторов), `RecordOrderPayment` (по webhook), `ChangeOrderStatus` (персонал, `requireMember`), `SyncOrderStatusFromPos` (идемпотентный вход для будущего POS-поллера, source=pos), `CancelOrder` (гость, пока created/paid). Запросы: `GetOrder` (свой гость или персонал), `GetMyOrders`, `GetVenueOrders` (фильтр по статусу) — общий read-model `OrderView`. Порт `OrderRealtimeNotifierInterface` → адаптер `Infrastructure/Mercure/MercureOrderNotifier` (тема `orders/{id}`). Doctrine `Order` (таблица `"order"` в кавычках — зарезервированное слово; items/history в JSON) + `OrderRepository` + миграция `Version20260708160000`. Actions: POST `/venues/{venueId}/orders` (оформить), GET `/venues/{venueId}/orders` (для точки), GET `/orders`, GET `/orders/{orderId}`, POST `/orders/{orderId}/status`, POST `/orders/{orderId}/cancel`. Webhook оплаты заказов и подписок идёт на один путь `/pay` — различаются по маркеру `Data.kind == "order"`, который виджет кладёт в платёж (без маркера — подписка).
>
> **Не вошло (осознанно):** конкретный **iiko-поллер доставки** (создание заказа в iiko Deliveries API + опрос статусов по таймеру) — это отдельный крупный объём на другом API iiko, чем меню из M4; вход в систему готов (`SyncOrderStatusFromPos`), сам поллер — следующий шаг (M5.1). Возврат средств при отмене оплаченного заказа — позже. `estimatedWaitMinutes` заполняется в M6. Проверено: `php bin/console lint:container` → OK.

### 9.2 `WaitTime` — примерное время ожидания (динамически)
> **Это ключевая фича. Формулу проектируем только после детального согласования входов и целей.**

**Уточнить до реализации (обязательно):**
- Что именно показываем: время до готовности, или до доставки (готовка + логистика)?
- Входные факторы формулы: текущая загрузка точки (число активных заказов в готовке), пропускная способность кухни, время суток/пиковые часы, размер заказа/трудоёмкость позиций, историческое фактическое время по точке, погода/пробки для доставки?
- Как часто пересчитывать: при каждом новом заказе, по таймеру, при смене статусов?
- Где показывать: гостю до оформления (оценка) и после (обновляемый ETA)?
- Целевая точность и как измеряем (сравнение прогноз vs факт)?

**Задачи (после согласования):**
1. Доменный сервис `WaitTimeEstimator` с методом-намерением `estimateWaitTime(...)` — чистая функция от согласованных входов, формула вынесена явно и прокомментирована ссылкой на договорённость.
2. Сбор фактических длительностей (по таймстемпам статусов заказа) в `WaitTimeEstimate`/историю для калибровки.
3. Пересчёт ETA по выбранным триггерам (новый заказ / смена статуса / таймер через Messenger).
4. Отдача ETA в ответах `Order`-фетчеров и push через Mercure.
5. Метрика «прогноз vs факт» для последующей настройки коэффициентов.

> **Статус: реализовано (M6, 2026-07-08).** Согласованные решения: показываем **по типу** — самовывоз до готовности (только кухня), доставка = готовка + логистическое плечо; факторы формулы — **текущая загрузка кухни + трудоёмкость заказа (единицы блюд) + исторический факт** (подмешивается, когда данных достаточно); пересчёт — **на событиях заказов + по таймеру**; калибровка — **настройки точки сейчас, фактический факт потом**.
>
> Домен `Application/WaitTime`: чистый `Service/WaitTimeEstimator` (формула вынесена и прокомментирована договорённостью: своё время = base + perUnit×units, где perUnit = смесь настроенного и исторического с весом 0.5; очередь = (заказов_впереди ÷ параллельная_мощность)×своё_время; в процессе готовки — только остаток по таймстемпу; доставка добавляет плечо), VO `WaitTimeInputs`; `Service/KitchenHistory` (среднее фактическое время/единицу по недавним заказам paid→ready, порог 5 сэмплов из 20); `Service/WaitTimeRecalculator` (реализует порт `Application/Order/WaitTime/WaitTimeRecalculatorInterface`) — пересчитывает ETA всех активных заказов точки и шлёт Mercure. Сущность `KitchenProfile` (baseMinutes/perUnitMinutes/parallelCapacity/deliveryMinutes, дефолты 10/4/3/30) + команда `SetKitchenProfile` (владелец) + запрос `EstimateWait` (предоценка гостю до заказа). Триггеры: обработчики Order (`RecordOrderPayment`/`ChangeOrderStatus`/`SyncOrderStatusFromPos`/`CancelOrder`) зовут `recalculateForVenue` через порт; таймер — консольная команда `app:wait-time:recalculate` (по cron, напр. раз в минуту). `Order` получил хелперы `unitCount()`/`enteredStatusAt()`; `OrderRepository` — `findInProgressByVenue`/`findRecentReadyByVenue`/`findVenueIdsInProgress`. Doctrine `KitchenProfile` + миграция `Version20260708170000`. Actions: PUT `/venues/{venueId}/kitchen-profile`, GET `/venues/{venueId}/wait-estimate?type=&units=`. ETA лежит в `estimated_wait_minutes` в `OrderView` и приходит realtime через Mercure.
>
> **Упрощения (осознанно):** плечо доставки — константа точки (без гео-маршрутизации/трекинга курьера, поэтому на on_the_way не уменьшается); час пик отдельным множителем не вводили (эффект пика улавливается через загрузку и исторический факт); метрика «прогноз vs факт» — как накопление в M7 вместе с тестами формулы. Проверено: `lint:container` OK, маршруты и команда зарегистрированы.

---

## 10. Порядок работ (вехи)

1. **M0. Фундамент.** Контекст воркспейса (резолвер + `workspaceId` в use-case), единый формат ответа/ошибок, каркас портов интеграций. Приведение `Users`/`Authorize` к одному пользователю (по итогу уточнения).
2. **M1. Деньги и владелец.** `Subscription` + `Billing` (CloudPayments), активация владельца по webhook.
3. **M2. Воркспейс.** Реализация `WorkspaceRepository`, CRUD, лимиты по тарифу.
4. **M3. Точки.** `Venue` CRUD + расписание.
5. **M4. POS + меню.** `PosIntegration` (iiko первым) + `Menu` с фоновым импортом через Messenger.
6. **M5. Заказы.** `Order` (оформление, оплата, статусы), витрина меню для гостей.
7. **M6. Киллер-фича.** `WaitTime` — формула, история, реалтайм ETA, калибровка.
8. **M7. Твёрдость.** Тесты (PHPUnit) на Handler'ы/Fetcher'ы и формулу, наблюдаемость, чистка неиспользуемого (`libs/YOOMONEY`).
9. **M8. Глобальная админка.** EasyAdmin-панель: метрики нагрузки, аудит изменений, подписки/оплаты, заказы, профили.
10. **M9. Скидки, промокоды, бонусы.** Домены `Promotion` (скидки + промокоды) и `Loyalty` (баллы/кэшбэк + уровни + штампы), гибкая настройка владельцем, применение в расчёте заказа. Подробный план — [`PLAN_PROMOTIONS.md`](./PLAN_PROMOTIONS.md).

Каждая веха — вертикальными срезами, с уточняющими вопросами **перед** каждым новым use-case.

> **Статус M8: реализовано (2026-07-08), кроме установки пакета.** Согласованные решения: UI — **EasyAdmin** (Symfony/Twig, в том же репо); доступ — **флаг ROLE_ADMIN на User** (отдельный сессионный firewall `admin` с form_login по телефону+пароль, вход только для `isAdmin=true` с заданным паролем); «нагрузка» — **прикладные метрики** (свои); аудит — **ключевые бизнес-события**.
>
> **Идентичность/безопасность:** Doctrine `User` реализует `UserInterface`+`PasswordAuthenticatedUserInterface`, добавлены `isAdmin`+`password` (миграция `Version20260708180000`); `security.yaml` — entity-провайдер `app_user_provider` по `phone`, firewall `admin` (^/admin, form_login `admin_login`/logout `admin_logout`, default_target `admin_dashboard`), access_control ROLE_ADMIN; firewall `api` получил явный `provider: users_in_memory` (иначе неоднозначность при 2 провайдерах). Логин-страница `AdminSecurityController` + `templates/admin/login.html.twig` (без зависимости от EA). Команда `app:admin:grant <phone> <password>` выдаёт права и хэширует пароль.
>
> **Аудит:** сущность `Infrastructure/Doctrine/Domain/Audit/AuditRecord` (audit_log, миграция `Version20260708190000`); `Infrastructure/Audit/AuditSubscriber` (Doctrine `#[AsDoctrineListener]` onFlush→снятие изменений из UoW, postFlush→сохранение) пишет created/updated/deleted по whitelist (User/Subscription/Order/Workspace/Membership/Venue/PosConnection/MenuItem), актор из Security (JwtUser→userId+phone, User→id+phone, иначе «система»), поля password/apiLoginEncrypted не логируются.
>
> **Метрики:** таблица `request_metric` (поминутные корзины, миграция `Version20260708200000`), `Infrastructure/Metrics/RequestMetricListener` (kernel.terminate, UPSERT ON CONFLICT, игнор `/_*`), `Infrastructure/Metrics/MetricsReader` (снимок: заказы по статусам/сегодня/активные, подписки по статусам, очередь Messenger pending/failed, объёмы users/workspaces/venues, серия запросов за час, ping БД — каждая выборка в try/catch).
>
> **EasyAdmin UI:** `Http/Admin/DashboardController` (route `admin_dashboard` `/admin`, стартовая — метрики через `templates/admin/dashboard.html.twig`, меню по разделам) + CRUD-контроллеры Order/Subscription/User/Workspace/Venue/PosConnection/AuditRecord (наблюдательные — read-only, кроме User и Venue где можно править флаги; секрет POS и пароль не выводятся). Enum-поля через `formatValue`.
>
> **Требует действий (устанавливает пользователь):** `composer require easycorp/easyadmin-bundle` (бандл уже добавлен в `bundles.php` и `composer.json`, но не установлен — до установки контейнер не соберётся); затем `doctrine:migrations:migrate` (4 миграции 180000–200000) и `php bin/console app:admin:grant <phone> <password>`. Проверено: `lint:container` OK для частей 1–3 (identity/security/audit/metrics), EA-контроллеры — `php -l` OK.

---

## 11. Нефункциональные требования и гигиена

- **Тесты:** unit на Handler/Fetcher/сервисы (особенно `WaitTimeEstimator` и биллинг), функциональные на ключевые Actions. F.I.R.S.T.
- **Миграции:** каждая новая таблица/поле — через `doctrine-migrations`; тенант-таблицы обязательно с `workspace_id` + индексом.
- **Безопасность:** проверка прав на уровне Handler (владелец管ает только своим воркспейсом); webhooks — с проверкой подписи; секреты POS — не в открытом виде.
- **Идемпотентность:** импорт меню и обработка webhook'ов — идемпотентные (upsert по внешнему id, дедуп платежей).
- **Наблюдаемость:** `LoggerService::toFile('домен/use-case', ...)`; логировать сбои интеграций и обработки Messenger.
- **Чистота имён:** ревью каждого PR на предмет «пустых» имён и линейной читаемости (см. `.agents/skills/clean-code`).

---

## 12. Definition of Done для каждого домена

- [ ] Согласованы бизнес-правила и контракты Action'ов (уточняющие вопросы закрыты).
- [ ] Доменная сущность + `RepositoryInterface` в `Application` (без Doctrine).
- [ ] Doctrine-сущность + репозиторий в `Infrastructure` + миграция.
- [ ] Command/Handler и/или Query/Fetcher с именованными аргументами и `\DomainException` на русском.
- [ ] Action(ы) с единым форматом ответа и одним внешним `try-catch`.
- [ ] Тенант-данные фильтруются по `workspaceId`.
- [ ] Тесты на ключевую логику.
- [ ] Имена читаемы, без `ensure`/`resolve`/`process`; код читается сверху вниз.
