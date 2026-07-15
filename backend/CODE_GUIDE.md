# CODE_GUIDE — эталон написания кода и документации

**Что это.** Практический, пример-ориентированный стандарт: **как здесь пишется код и документация**,
чтобы он оставался линейным, читаемым, SOLID и одинаково расширяемым для **ядра** и для
**кастомизации** (оверлея). Это единая «точка правды» по стилю.

**Связь с другими документами (не дублируем — ссылаемся):**
- `architecture.md` — правила слоёв DDD/Symfony (что где лежит). Здесь — **как именно** это писать.
- `PLAN_FLEET.md` — модель «ядро + оверлей владельца», публичная поверхность API (§17.D),
  точки расширения (§17.E). Здесь — как писать код, чтобы он ложился в эту модель.
- `REFACTOR_NAMING.md` — конвенция именования use-case/репозиториев (сведена в §7 ниже).

**Локальное правило для этого репозитория (по договорённости с владельцем):**
- Миграции БД в рабочих фазах можно не заводить: контейнеры/БД пересоздаются, поэтому допустимо менять
  код и схему напрямую без миграционных файлов, если владелец явно не попросил обратного.

**Золотое правило:** *код читается сверху вниз как история — вход, проверки, действие, выход. Никаких
сюрпризов, никакой магии, минимум ветвлений.* Если метод не читается за один проход — его надо
разбить.

---

## 1. Философия: линейный, понятный код

Семь правил, которым подчинён весь остальной документ:

1. **Ранний возврат (guard clauses).** Сначала отсекаем невалидные случаи и выходим, потом — основная
   логика без вложенности. Никаких `else` после `return`/`throw`.
2. **Плоско, а не глубоко.** Вложенность ≤ 2–3 уровней. Глубже — извлекай приватный метод.
3. **Одна ответственность на единицу.** Класс/метод делает одну вещь; имя это отражает.
4. **Явное лучше умного.** Читаемость важнее «краткости». Никаких трюков ради строк.
5. **Мутация и чтение раздельно.** Команда меняет состояние, запрос читает — не смешиваем.
6. **Тонкие края (Http/Console), толстый домен.** В контроллере/команде — только транспорт: разобрать
   вход → позвать Handler/Fetcher → отдать ответ. Бизнес-логика — в `Application`.
7. **Границы через интерфейсы.** Домен зависит от портов (интерфейсов), а не от реализаций — так и
   ядро, и оверлей расширяются без правки чужого кода.

### Линейность на примере (плохо → хорошо)

```php
// ПЛОХО: вложенность, else после проверки, логика тонет в ветвлениях
public function handle(RemoveStaffMemberCommand $command): void
{
    $workspace = $this->workspaces->findById($command->workspaceId);
    if ($workspace !== null) {
        if ($workspace->ownerId === $command->ownerId) {
            $membership = $this->memberships->findByWorkspaceAndUser($command->workspaceId, $command->staffUserId);
            if ($membership !== null && !$membership->isOwner()) {
                $this->memberships->delete($membership->id);
            } else {
                throw new \DomainException('Нельзя удалить');
            }
        } else {
            throw new \DomainException('Недостаточно прав');
        }
    } else {
        throw new \DomainException('Воркспейс не найден');
    }
}
```

```php
// ХОРОШО (реальный стиль проекта): guard-clauses, плоско, читается сверху вниз
public function handle(RemoveStaffMemberCommand $command): void
{
    $workspace = $this->workspaces->findById($command->workspaceId);

    if ($workspace === null) {
        throw new \DomainException('Воркспейс не найден');
    }

    if ($workspace->ownerId !== $command->ownerId) {
        throw new \DomainException('Недостаточно прав');
    }

    $membership = $this->memberships->findByWorkspaceAndUser(
        workspaceId: $command->workspaceId,
        userId: $command->staffUserId,
    );

    if ($membership === null) {
        throw new \DomainException('Сотрудник не найден в воркспейсе');
    }

    if ($membership->isOwner()) {
        throw new \DomainException('Нельзя удалить владельца воркспейса');
    }

    $this->memberships->delete($membership->id);
}
```

---

## 2. Слои и направление зависимостей

Полные правила — в `architecture.md §1`. Кратко (стрелка = «может импортировать»):

```
Http  ─┐
Console─┼─►  Application  ─►  Shared          (домен зависит от портов, не от реализаций)
        │        ▲
Infrastructure ──┘   (реализует порты Application/Shared)

Custom (оверлей) ─►  Application / Shared      (НО НЕ наоборот — ядро не знает Custom)
```

- **`Application/{Domain}`** — доменный слой: сущности, порты (интерфейсы репозиториев/сервисов),
  Command/Handler, Query/Fetcher, доменные сервисы, события. **Не знает** про Doctrine/HTTP/внешние API.
- **`Infrastructure`** — адаптеры: Doctrine-сущности и репозитории, клиенты внешних систем.
- **`Http` / `Console`** — тонкие точки входа. Зовут Handler/Fetcher, своей логики не содержат.
- **`Shared`** — переиспользуемое: `Contract/*` (провайдер-независимые порты), сервисы, enum, VO.
- **`Custom/*`** (оверлей владельца, см. `PLAN_FLEET.md §5`) — зависит от ядра, **ядро на него не
  ссылается** (стережёт `CustomizationBoundaryTest`).

**Незыблемо:** зависимости идут **внутрь**, к домену. Домен ничего не знает о том, кто его вызывает и
как хранятся данные.

---

## 3. SOLID в этом проекте (с примерами и связью «ядро/кастом»)

| Принцип | Как выражен здесь | Почему помогает поддержке и расширению |
|--------|-------------------|----------------------------------------|
| **S — Single Responsibility** | `Handler` = один use-case на запись; `Fetcher` = одно чтение; сущность = свои инварианты; репозиторий = только доступ к данным | Изменение одной причины трогает один класс. |
| **O — Open/Closed** | Порт + дефолтный адаптер. Новое поведение = **новая реализация**, а не правка существующей. Оверлей подменяет порт через DI-alias (Replace, `PLAN_FLEET §6.1`) | Ядро расширяется, не изменяясь; кастом добавляется, не трогая ядро. |
| **L — Liskov Substitution** | Любой адаптер порта взаимозаменяем; контракт порта стабилен и версионируется (`@api`, `core-contract.json`) | Замена реализации (в т.ч. кастомной) не ломает вызывающий код. |
| **I — Interface Segregation** | Маленькие порты. Пример: `OrderPaymentGatewayInterface` — **один** метод `createPayment()` | Реализовать порт (в т.ч. в оверлее) легко; нет «толстых» интерфейсов-обузы. |
| **D — Dependency Inversion** | Домен зависит от `...RepositoryInterface`; реализация — в `Infrastructure`; связывается автовайрингом | Инфраструктуру/провайдера меняем, домен не трогаем. |

**Мостик к кастомизации:** именно D+O+I делают оверлей возможным. Ядро объявляет **порт**, оверлей даёт
**свою реализацию** — и подменяет её одной строкой DI. Поэтому: *проектируя фичу ядра, спрашивай — какой
стабильный порт я оставляю для подмены/расширения?*

---

## 4. Канонические строительные блоки (anatomy + шаблоны)

Все примеры — реальные из этого репозитория. Копируй форму.

### 4.1 Доменная сущность (чистый PHP)

- Без Doctrine-атрибутов. Публичные `readonly` поля для идентичности/данных; изменяемое состояние —
  через методы, охраняющие инварианты. Фабрика `buildNew(...)` для создания, `assignId()` — присвоение
  id после сохранения.

```php
final class LoyaltyRedemption
{
    private function __construct(
        public ?int $id,
        public readonly int $workspaceId,
        public readonly int $accountId,
        public readonly int $orderId,
        public readonly int $customerId,
        public readonly int $points,
        public LoyaltyRedemptionStatusEnum $status,
    ) {}

    public static function buildNew(int $workspaceId, int $accountId, int $orderId, int $customerId, int $points): self
    {
        return new self(null, $workspaceId, $accountId, $orderId, $customerId, $points, LoyaltyRedemptionStatusEnum::Reserved);
    }

    public function assignId(int $id): void { $this->id = $id; }

    public function isReserved(): bool { return $this->status === LoyaltyRedemptionStatusEnum::Reserved; }

    public function finalize(): void
    {
        if (!$this->isReserved()) {
            throw new \DomainException('Списание не в статусе резерва');
        }
        $this->status = LoyaltyRedemptionStatusEnum::Finalized;
    }
}
```

Правила: методы состояния **сами защищают инварианты** (бросают `DomainException`); никаких сеттеров
«на всё»; единицы измерения — в имени поля (`points`, `priceKopecks`, `...BasisPoints`).

### 4.2 Порт репозитория (интерфейс)

- Живёт рядом с сущностью в `Application/{Domain}/Entity/{Entity}/`.
- **Конвенция методов:** `find...` → nullable/коллекция; `get...` → бросает при отсутствии;
  `has/exists/count...` → bool/int; `save/delete` — запись. Параметр в имени, если неочевиден (`By{Param}`).

```php
interface WorkspaceRepositoryInterface
{
    public function save(Workspace $workspace): int;
    public function findById(int $id): ?Workspace;
    public function findBySlug(string $slug): ?Workspace;

    /** @param int[] $ids @return Workspace[] */
    public function findAllByIds(array $ids): array;

    public function countByOwner(int $ownerId): int;
}
```

### 4.3 Doctrine-адаптер репозитория

- В `Infrastructure/Doctrine/Domain/{Domain}/`. Наследует `ServiceEntityRepository`, реализует порт.
- **Маппит доменную сущность ↔ ORM-запись** (не отдаёт наружу ORM-объекты): приватный `toEntity()`;
  в `save()` после flush — `assignId()`. Интерфейс ↔ реализация связывается автовайрингом (алиас не нужен).

```php
/** @extends ServiceEntityRepository<StampProgram> */
class StampProgramRepository extends ServiceEntityRepository implements StampProgramRepositoryInterface
{
    public function __construct(ManagerRegistry $registry) { parent::__construct($registry, StampProgram::class); }

    public function save(StampProgramEntity $program): int
    {
        $record = $program->id !== null ? $this->find($program->id) : new StampProgram();
        // ... перенос полей domain → record ...
        $this->getEntityManager()->persist($record);
        $this->getEntityManager()->flush();

        $program->assignId($record->getId());

        return $record->getId();
    }

    public function findByWorkspace(int $workspaceId): ?StampProgramEntity
    {
        $record = $this->findOneBy(['workspaceId' => $workspaceId]);

        return $record !== null ? $this->toEntity($record) : null;
    }

    private function toEntity(StampProgram $record): StampProgramEntity { /* record → domain */ }
}
```

### 4.4 Команда (DTO) + Обработчик (Handler) — запись

- **Команда** — неизменяемый DTO входа (`public readonly`), без логики.
- **Handler** — один публичный `handle(Command): Result|void`. Внутри: guard-clauses → доменное
  действие → сохранение. Инжектит **порты**, не реализации.

```php
final class AdjustLoyaltyBalanceCommand
{
    public function __construct(
        public readonly int $ownerId,
        public readonly int $workspaceId,
        public readonly int $customerId,
        public readonly int $deltaPoints,
        public readonly ?string $comment,
    ) {}
}
```

Handler — см. эталон линейности в §1 (guard-clauses + одно действие). Правила: проверка прав —
**в домене** (`ownerId`-сверка), не в контроллере; многошаговые инварианты денег/остатков — под
транзакцией/блокировкой строки (см. комментарии-«почему» в `Loyalty/Service/OrderRewards`).

### 4.5 Запрос (Query) + Фетчер (Fetcher) — чтение

- **Только чтение**, никаких мутаций. Возвращает DTO/`View`/массивы для транспорта. Сложную сборку —
  в приватные методы. Форму массивов документируй PHPDoc.

```php
class GetClientProductsByCategoryIdFetcher
{
    public function __construct(
        private readonly ClientMenuAccess $access,
        private readonly CategoryRepositoryInterface $categories,
        private readonly MenuItemRepositoryInterface $items,
        private readonly ClientProductAssembler $assembler,
    ) {}

    /** @return array<int, array<string, mixed>> */
    public function fetch(GetClientProductsByCategoryIdQuery $query): array
    {
        $this->access->venueOfWorkspace($query->workspaceSlug, $query->venueId);

        $category = $this->categories->findById($query->categoryId);

        if ($category === null || $category->venueId !== $query->venueId) {
            throw new \DomainException('Категория не найдена');
        }

        $cards = [];

        foreach ($this->items->findActiveByVenue($query->venueId) as $item) {
            if ($item->categoryExternalId !== $category->externalId || !$item->isAvailable) {
                continue;
            }
            $cards[] = $this->cardFor($item);
        }

        return $cards;
    }

    /** @return array<string, mixed> */
    private function cardFor(MenuItem $item): array { /* ... */ }
}
```

### 4.6 HTTP Action (тонкий контроллер)

- Один класс на эндпоинт, метод `handle`. **Только транспорт:** разобрать вход (`Assert`), позвать
  Handler/Fetcher, вернуть `ApiResponse`. Ошибки — единым `try/catch` (см. §6).
- Импортируем описательный класс use-case **напрямую** (без `as`-алиасов).

```php
class SetLoyaltyTiersAction extends AbstractController
{
    public function __construct(private readonly SetLoyaltyTiersHandler $setLoyaltyTiers) {}

    #[Route('/workspaces/{workspaceId}/loyalty/tiers', name: 'app_set_loyalty_tiers', methods: ['PUT'], requirements: ['workspaceId' => '\d+'])]
    public function handle(Request $request, int $workspaceId): Response
    {
        try {
            $body = $request->toArray();
            Assert::isArray($body['tiers'] ?? null, 'Ожидается список уровней в поле tiers');

            /** @var JwtUser $user */
            $user = $this->getUser();

            $this->setLoyaltyTiers->handle(new SetLoyaltyTiersCommand(
                ownerId: $user->claims->userId,
                workspaceId: $workspaceId,
                tiers: $this->parseTiers($body['tiers']),
            ));

            return ApiResponse::success();
        } catch (InvalidArgumentException | \DomainException $e) {
            return ApiResponse::error($e->getMessage());
        } catch (\Throwable $e) {
            LoggerService::toFile(fileName: 'loyalty/tiers', message: $e->getMessage());

            return ApiResponse::error('Что-то пошло не так', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
```

Единый формат ответа — `App\Http\Response\ApiResponse` (`{ is_success: true, ... }` / `{ is_success:
false, error, code? }`). Разбор длинного тела — в приватный метод (`parseTiers`), чтобы `handle`
оставался линейным.

### 4.7 Console command (тонкая обёртка)

- `#[AsCommand(name: 'app:домен:действие', description: ...)]`, инжектит **Handler**, `execute()` —
  разобрать опции → позвать Handler → отчитаться `SymfonyStyle`. Своей бизнес-логики нет (как Http).

```php
#[AsCommand(name: 'app:orders:expire-abandoned', description: 'Отменить брошенные неоплаченные заказы...')]
final class ExpireAbandonedOrdersCommand extends Command
{
    public function __construct(private readonly ExpireAbandonedOrdersHandler $expireAbandonedOrders)
    { parent::__construct(); }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $ttlMinutes = (int) $input->getOption('ttl');

        if ($ttlMinutes < 1) {
            $io->error('ttl должен быть ≥ 1');
            return Command::FAILURE;
        }

        $this->expireAbandonedOrders->handle(new ExpireAbandonedOrders($ttlMinutes));

        return Command::SUCCESS;
    }
}
```

### 4.8 Порт-контракт в `Shared/Contract` + дефолтный адаптер + Replace оверлеем

Провайдер-независимый порт, который может подменить оверлей:

```php
namespace App\Shared\Contract\Payment\OrderPaymentGateway;

interface OrderPaymentGatewayInterface
{
    public function createPayment(OrderPaymentRequest $request): OrderPaymentInstruction;
}
```

- **Ядро**: дефолтная реализация связывается автовайрингом.
- **Оверлей (Replace)**: в `custom/config/services.yaml` — `App\...\OrderPaymentGatewayInterface: {
  alias: App\Custom\Acme\Payment\AcmeGateway }`. Никаких `if (workspaceId === …)` — на сервере один
  тенант, выбор реализации статичен (см. `PLAN_FLEET §6.1`).

### 4.9 Доменное событие + слушатель / 4.10 Messenger message + handler

- **Событие** — POPO в `Application/{Domain}/Events/`; издаётся доменом после факта. Слушатели ядра — в
  `Infrastructure`/`Http`; оверлей вправе подписаться на **публичные** (`@api`) события.
- **Async-сообщение** — класс в `Infrastructure/Messenger/{Topic}/`, роутинг на транспорт `async` в
  `messenger.yaml`, тонкий `#[AsMessageHandler]`. Тяжёлое/внешнее (письма, SMS, импорт меню) — только
  так. Payload сообщения/события — часть контракта (аддитивно менять можно, ломать — мажор, `PLAN_FLEET §17.D`).

---

## 5. Правила линейности (чек-лист метода)

- [ ] Guard-clauses в начале, ранний `return`/`throw`; **нет `else` после выхода**.
- [ ] Вложенность ≤ 2–3; глубже — приватный метод с говорящим именем.
- [ ] Один уровень абстракции в методе (не мешаем «разобрать запрос» и «посчитать бонусы»).
- [ ] `match` вместо лестниц `switch`/`elseif` для отображений (см. `MenuImageEntityLocator`).
- [ ] Цикл: `continue` для пропуска, тело — плоское.
- [ ] Нет бизнес-логики в `Http`/`Console` — только транспорт.
- [ ] Метод помещается «в один экран»; god-методы разбиты.
- [ ] Именованные аргументы для 3+ параметров (читаемость вызова).

---

## 6. Ошибки и валидация (единый контур)

| Слой | Что бросает | Смысл |
|------|-------------|-------|
| Http (вход) | `Webmozart\Assert` → `InvalidArgumentException` | Формат/наличие полей запроса |
| Application (домен) | `\DomainException` | Нарушение бизнес-правила/прав/инварианта |
| Infrastructure | своё → домен транслирует | Технический сбой |

- В Action — **один** `try/catch`: `InvalidArgumentException|DomainException` → `ApiResponse::error()`
  (400); `\Throwable` → лог (`LoggerService`) + `error('Что-то пошло не так', 500)`. Внутренние детали
  наружу не отдаём.
- Проверка **прав** — в домене (Handler сверяет `ownerId`/членство), не в контроллере.
- **Рекомендация к улучшению (необязательна, но желательна):** повторяющийся `try/catch` вынести в
  единый `kernel.exception`-listener, мапящий `DomainException/InvalidArgument → 400`,
  `\Throwable → 500 + лог`. Тогда Action станет ещё тоньше (только happy-path). Вводить — отдельным
  срезом, единообразно по всем экшенам.

---

## 7. Именование (сведено из `REFACTOR_NAMING.md`)

- **Классы use-case — роль суффиксом:** `{UseCase}Command` / `{UseCase}Handler` / `{UseCase}Query` /
  `{UseCase}Fetcher`. Никаких generic-`Command`/`Handler`.
- **Папки команд** — императив (`PlaceOrder`, `ChangeOrderStatus`). **Папки запросов** — кодируют
  параметр: `Get{Entity|Entities}By{Param}`, коллекция во множественном, идентификатор с суффиксом
  `Id`/`Ids` (`GetOrdersByCustomerId`, `GetClientProductById`).
- **Методы репозитория:** `find...`=nullable/коллекция, `get...`=бросает, `has/exists/count...`=bool/int;
  `By{Param}` где неочевидно.
- **Action:** импорт описательного класса напрямую, инжект по FQCN (без `as`-алиасов).
- **Enum** — `{Entity}StatusEnum`/`{Entity}TypeEnum`; **DTO/View** — описательные (`PlacedOrderDTO`,
  `OrderView`, `QuoteView`).
- **Таблицы кастома** — `custom_{module}_*` (изоляция, `PLAN_FLEET §17.E`).
- Всё на английском в коде; текст ошибок/логов/доков — на русском (включая `ApiResponse::error(...)` и stderr сообщений консольных команд).

---

## 8. Документация в коде (docblock-стандарт)

**Что документируем — «почему», а не «что».** Код и так говорит что; комментарий объясняет намерение,
инвариант, единицы и неочевидные решения.

- **Класс** — краткий docblock: зачем он и его роль (см. `OrderRewards`, `GetClientProductsByCategoryIdFetcher`).
- **Обязательно комментируем:** инварианты и **идемпотентность** (эталон — комментарии в `OrderRewards::
  accrueOnCompleted` про «одна Earn-запись = маркер», уникальный индекс, блокировки строк); **единицы**
  (`Kopecks`, `BasisPoints`); причины неочевидного порядка/защёлок; ссылки на баг/решение.
- **PHPDoc-типы** для массивов и generics — обязательно: `@return list<array{points:int, balance_after:int}>`,
  `@param int[] $ids`, `@extends ServiceEntityRepository<StampProgram>`. Это и типобезопасность, и вход
  для OpenAPI/статанализа.
- **`@api` / `@internal`** — граница публичной поверхности (порты, события, сообщения, каркас
  кастомизации помечаем `@api`; всё прочее — `@internal`). Правило эволюции — `PLAN_FLEET §17.D`
  (deprecation ≥2 минора → мажор).
- **Не комментируем очевидное** (`$i++ // инкремент` — запрещено). Мёртвые комментарии/закомmented-код —
  удаляем.
- `declare(strict_types=1);` в каждом файле; типизируем **всё** (аргументы, возвраты, свойства).

---

## 9. Ведение документации проекта (MD)

Документация — такая же «линейная и понятная», как код.

- **Виды:** `PLAN_*` (планы/срезы), ADR-разделы (решение + альтернативы + вердикт), `*_GUIDE`
  (операционные рецепты для холодной сессии), `architecture.md`/`CODE_GUIDE.md` (правила).
- **Стиль:** короткие абзацы; таблицы для решений/сопоставлений; явные строки **«Решение:»**/
  **«DoD:»**; статусы срезов (`✅ СДЕЛАНО` / `⬜`); даты — абсолютные.
- **Структура файла:** сверху — «что это» и связи с другими доками (как здесь). Не дублируем — ссылаемся.
- **Актуализация:** меняешь поведение — обнови профильный `*_GUIDE`/план в том же PR. Устаревшее помечай
  «заморожено» со ссылкой на замену (как Variant A → `PLAN_FLEET`).
- **Долгая память ассистента** — в `MEMORY.md`/`memory/*` (одна мысль = один файл, индекс — одной
  строкой). Не кладём туда то, что и так в коде/git.

---

## 10. Расширяемость: ядро vs кастом

**Добавить фичу ядра** (едет всем): по слоям сверху вниз — сущность+порт (`Application/{Domain}/Entity`)
→ Doctrine-адаптер+миграция (`Infrastructure`) → use-case (`Command/Handler` или `Query/Fetcher`) →
точка входа (`Http`/`Console`). Продаваемость — через `FeatureGate`/лицензию (`PLAN_FLEET §10`).

**Добавить кастом владельца** (оверлей): по `PLAN_FLEET §5/§17.E` — модуль в `custom/src/{Module}` с тем
же строением, что ядро; активация = наличие модуля; гейтинг — `CustomAccess`/`FeatureGate`. Разрешено:
новые эндпоинты/сущности (`custom_{module}_*`)/роли/настройки/подписки на **публичные** события/Replace
порта. Запрещено: импорт `@internal` ядра, миграции чужих таблиц, правка `config/packages` ядра.

**Проектируй «под оверлей» заранее:** для каждой значимой стратегии ядра — **маленький стабильный
порт** (`@api`), издавай **доменные события** после ключевых фактов, держи интерфейсы узкими. Тогда
владелец расширяется через DI/подписку, не форкая ядро, а твои обновления ядра его не ломают.

**Инвариант границы (незыблемо):** `App\Application|Infrastructure|Http|Console` **никогда** не
импортирует `App\Custom\*` и не содержит имён клиентов. Стережёт `CustomizationBoundaryTest`.

---

## 11. Тестирование

- **Unit на каждый use-case:** Handler/Fetcher тестируем, **мокая порты** (репозитории/сервисы) — домен
  без БД. Проверяем guard-ветки (все `DomainException`) и happy-path.
- **Сущности** — тест инвариантов (методы состояния бросают на нарушении).
- **Boundary-тест** — `CustomizationBoundaryTest` (ядро ⇏ Custom) обязан быть зелёным.
- **Оверлей** — свои тесты в `custom/tests`, независимые от тестов ядра; контракт-кит ядра
  (`app:custom:doctor`, `PLAN_FLEET §17.D/E`) проверяет совместимость.
- **Именование теста** — по поведению (`it_rejects_removal_of_owner`), а не по методу.

---

## 12. Definition of Done (чек-листы)

**Новый use-case записи (Command):**
- [ ] `Application/{Domain}/Command/{UseCase}/{UseCase}Command.php` (readonly DTO) + `{UseCase}Handler.php`.
- [ ] Handler инжектит только порты; guard-clauses; права проверены в домене; при денежных инвариантах — транзакция.
- [ ] Точка входа тонкая (Http/Console) через `ApiResponse`/`SymfonyStyle`.
- [ ] Unit-тесты (guard-ветки + happy). Именование по конвенции §7. Docblock «почему» где неочевидно.

**Новый запрос (Query):**
- [ ] Папка `Get{...}By{Param}`; `{UseCase}Query` + `{UseCase}Fetcher` (только чтение) + `View`/DTO.
- [ ] PHPDoc-типы форм массивов; сложная сборка — приватные методы.

**Новый порт (Shared/Contract или Application):**
- [ ] Интерфейс маленький (ISP), помечен `@api`; дефолтный адаптер в `Infrastructure`.
- [ ] Учтено, что оверлей может Replace-нуть его; при изменении — deprecation-цикл (не ломать).

**Новый оверлей-модуль:** — по `PLAN_FLEET §5.6/§17.E` (манифест, `custom_{module}_*`, гейтинг, свои тесты).

**Изменение публичного контракта (`@api`, `/api/v1`, событие/сообщение):**
- [ ] Аддитивно — минор; ломающе — новый порт/`/api/v2` + deprecation старого ≥2 минора; бамп `core-contract.json`; отметка в CHANGELOG.

---

## 13. Анти-паттерны (запрещено)

- `else`/`elseif`-лестницы и вложенность после guard-clause; god-методы.
- Бизнес-логика в `Http`/`Console`; прямой доступ к Doctrine из домена/контроллера.
- Возврат ORM-сущностей наружу из репозитория (только доменные сущности/DTO).
- Смешение чтения и записи в одном use-case.
- generic-имена `Command`/`Handler`/`Query`/`Fetcher`; `as`-алиасы в Action.
- «Толстые» интерфейсы; реализация вместо интерфейса в конструкторе домена.
- `if (workspaceId === N)`/`switch(slug)` и импорт `App\Custom\*` из ядра.
- Клиентская логика в таблицах ядра; миграции кастома в общей истории ядра.
- Комментарии-очевидности; закомmented-код; отсутствие типов/`strict_types`.
- Ломающее изменение `@api`-порта без deprecation-цикла.
