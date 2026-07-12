# Домен Order — как работает

Домен оформляет и ведёт заказ гостя в точке: считает цену на сервере, принимает
онлайн-оплату, гоняет заказ по статусам и шлёт реалтайм-обновления. Namespace
`App\Application\Order\...` (слой прикладной логики — без Doctrine и HTTP). Doctrine-сущности
и репозитории — в `App\Infrastructure\Doctrine\Domain\Order`, HTTP-экшены — в
`App\Http\Action\Order`. Все пути ниже относительны `backend/`.

Заказ оформляет **только авторизованный** пользователь (JWT). Контакты (имя, телефон, адрес)
и цены фиксируются снимком в заказе — гость не подменит их после оформления. Мультитенантность —
по `workspace_id`, точка (`venue_id`) принадлежит воркспейсу.

## 1. Эндпоинты

HTTP-слой — Symfony-контроллеры-Action с атрибутами `#[Route]`, префикс `/api/v1`
(`config/routes.yaml`), под JWT-файрволом `api`.

| Метод | Роут | Экшен | Назначение |
|-------|------|-------|-----------|
| POST | `/api/v1/venues/{venueId}/orders/quote` | `QuoteOrderAction` | Предпросмотр цены заказа (без создания) |
| POST | `/api/v1/venues/{venueId}/orders` | `PlaceOrderAction` | Оформить заказ + инициировать оплату |
| GET | `/api/v1/orders` | `GetMyOrdersAction` | Заказы текущего пользователя |
| GET | `/api/v1/orders/{orderId}` | `GetOrderAction` | Один заказ |
| GET | `/api/v1/venues/{venueId}/orders` | `GetVenueOrdersAction` | Лента заказов точки (персонал) |
| POST | `/api/v1/orders/{orderId}/status` | `ChangeOrderStatusAction` | Смена статуса персоналом |
| POST | `/api/v1/orders/{orderId}/cancel` | `CancelOrderAction` | Отмена заказа |

`quote` и `place` считают цену одним и тем же калькулятором — предпросмотр совпадает с
оформлением 1:1. Подтверждение оплаты приходит **не сюда**, а на публичный вебхук платёжного
провайдера (домен `Billing`), который дёргает `RecordOrderPayment` (см. §4).

## 2. Карта компонентов

```
Order/
├─ Entity/Order/                    агрегат + перечисления (без инфраструктуры)
│  ├─ Order                          агрегат: карта переходов allowedNextStatuses, история
│  ├─ OrderItem / OrderItemModifier  позиции с зафиксированными ценами (lineTotalKopecks)
│  ├─ OrderRepositoryInterface       порт хранилища (find…/save/hasPaidOrBeyond…/findInProgress…)
│  ├─ OrderStatusEnum                created→paid→accepted→cooking→ready→on_the_way→completed | canceled
│  ├─ OrderTypeEnum                  delivery | pickup
│  └─ OrderStatusSourceEnum          customer | staff | pos | system (кто инициировал переход)
│
├─ Command/                         use-case'ы записи ({UseCase}Command + Handler)
│  ├─ PlaceOrder                      оформление (+ PlacedOrderDTO с платёжной инструкцией)
│  ├─ RecordOrderPayment              провести оплату по вебхуку (идемпотентно)
│  ├─ ChangeOrderStatus               смена статуса персоналом
│  ├─ CancelOrder                     отмена + откат резервов/скидок
│  ├─ SyncOrderStatusFromPos          идемпотентный вход для поллера POS (source=pos)
│  └─ ExpireAbandonedOrders           крон: отменить неоплаченные Created старше TTL
│
├─ Query/                           use-case'ы чтения (Query + Fetcher), read-model рядом
│  ├─ QuoteOrder                      предпросмотр цены → QuoteView
│  ├─ GetOrderById / GetOrdersByCustomerId / GetOrdersByVenueId
│  └─ OrderView                       единый read-model заказа для ответов API
│
├─ Pricing/                         серверный расчёт цены (чистый, без записи)
│  ├─ OrderPriceCalculator           сборка позиций по меню + скидки + баллы → OrderPriceBreakdown
│  ├─ CartLine / ComboCartLine        вход: позиции и комбо из тела запроса
│  ├─ PricingLine / OrderPricingRequest / OrderPricingResult   контракт к движку скидок
│  ├─ OrderPricingInterface          порт скидок (реализует Promotion)
│  └─ AppliedDiscount / OrderPriceBreakdown   результат расчёта
│
├─ Rewards/                         порт лояльности (реализует Loyalty)
│  ├─ OrderRewardsInterface          quoteRedeem/reserveOnPlace/finalizeOnPaid/currentTierDiscount
│  └─ RedeemQuoteRequest / RedeemQuoteResult / TierDiscount
│
├─ Realtime/OrderRealtimeNotifierInterface   порт реалтайма (реализует Mercure-адаптер)
└─ WaitTime/WaitTimeRecalculatorInterface    порт пересчёта ETA (реализует WaitTime)
```

**Порты и адаптеры.** Order задаёт границы интерфейсами, а реализуют их соседние домены —
Order ни от кого не зависит напрямую:

| Порт (в `Order/`) | Реализация |
|-------------------|-----------|
| `OrderPricingInterface` | `Application/Promotion/Service/PromotionPricing` |
| `OrderRewardsInterface` | `Application/Loyalty/Service/OrderRewards` |
| `WaitTimeRecalculatorInterface` | `Application/WaitTime/Service/WaitTimeRecalculator` |
| `OrderRealtimeNotifierInterface` | `Infrastructure/Mercure/MercureOrderNotifier` (тема `orders/{id}`) |
| `OrderRepositoryInterface` | `Infrastructure/Doctrine/Domain/Order/OrderRepository` |
| `OrderPaymentGatewayResolverInterface` | `Shared/Contract/Payment` → per-workspace шлюз (домен `Billing`) |

## 3. Поток: POST `/venues/{venueId}/orders/quote` (предпросмотр)

Вход: `type`, `lines[]` (позиции), `combos[]`, `promocode?`, `points_to_spend?`.
`QuoteOrderFetcher` зовёт `OrderPriceCalculator::calculate(requireVenueOpen: false)` —
тот же расчёт, что при оформлении, но ничего не пишет и не проверяет часы работы (цену можно
посмотреть в любое время). Возвращает `QuoteView`: subtotal, скидки (`applied_discounts`),
списываемые баллы, сумма к оплате. Предпросмотр не резервирует ни баллы, ни лимиты промо.

## 4. Поток: POST `/venues/{venueId}/orders` (оформление) → оплата

`PlaceOrderHandler`:

```
[1] OrderPriceCalculator->calculate(requireVenueOpen: true)
     ├─ точка существует, активна и открыта сейчас (по таймзоне точки), поддерживает тип заказа
     ├─ позиции/комбо собираются по АКТУАЛЬНОМУ меню точки → серверные цены (гость не подменит)
     ├─ скидки: OrderPricingInterface->priceOrder (промо + скидка уровня лояльности)
     └─ баллы: OrderRewardsInterface->quoteRedeem (списание поверх скидок, от суммы после промо)
[2] WorkspaceAccess->requireActiveWorkspace() — воркспейс без активной подписки заказы не берёт
[3] доставка без адреса → \DomainException; самовывоз → адрес обнуляется
[4] Order::buildNew(...) — статус created, invoiceId = UUID, итог = subtotal − скидки − баллы
[5] TransactionInterface->wrap (атомарно):
     ├─ orders->save(order)
     ├─ orderPricing->recordApplied — фиксация скидок в леджере + счётчики лимитов промо
     ├─ orderRewards->reserveOnPlace — резерв списываемых баллов (спишутся при оплате)
     └─ если payable == 0 (всё покрыто баллами/промо): registerPayment на сервере +
        finalizeOnPaid — онлайн-оплаты для нулевого заказа не будет
[6] payable == 0 → publishStatus + recalculateForVenue, ответ paymentRequired=false
[7] payable > 0 → ПОСЛЕ коммита orderPaymentGateways->forWorkspace()->createPayment(...)
     внешний вызов вне транзакции; провайдер недоступен → заказ остаётся в created
     и позже гасится кроном ExpireAbandonedOrders с возвратом резервов
```

Ответ (`PlacedOrderDTO`): `order_id`, `payment_required`, `payment_instruction` (данные для
платёжного виджета CloudPayments/ЮKassa).

**Подтверждение оплаты.** Приходит асинхронно вебхуком провайдера в домен `Billing`, тот зовёт
`RecordOrderPayment` — идемпотентно (`Order::isAwaitingPayment()`: повторный вебхук по уже
оплаченному заказу — ранний no-op). Оплата переводит `created → paid`, списывает резерв баллов,
публикует статус в Mercure и запускает пересчёт ETA точки.

## 5. Жизненный цикл заказа (статусы)

Карта переходов зашита в `Order::allowedNextStatuses()` и читается сверху вниз:

```
created ──оплата(system)──▶ paid ──▶ accepted ──▶ cooking ──▶ ready ──┬─(delivery)─▶ on_the_way ──▶ completed
                                                                      └─(pickup)─────────────────▶ completed
из любого не финального статуса ──▶ canceled
```

- `on_the_way` — только для доставки; самовывоз завершается прямо из `ready`.
- `completed` и `canceled` — финальные.
- Каждый переход пишется в `history` с источником (`OrderStatusSourceEnum`: кто инициировал —
  гость, персонал, POS, система).
- `ChangeOrderStatus` — ручные переходы персоналом; `SyncOrderStatusFromPos` — идемпотентный
  вход под будущий поллер iiko (source=pos); `CancelOrder` откатывает применённые скидки и
  возвращает зарезервированные баллы (в транзакции).

Смены статуса с денежными/бонусными эффектами обёрнуты в `TransactionInterface::wrap`; реалтайм
и пересчёт ETA выносятся **за** транзакцию (публикуем после успешного коммита).

## 6. Ценообразование (`Pricing/OrderPriceCalculator`)

Единая точка расчёта для quote и оформления — чистая функция без побочных эффектов
(леджер скидок и резерв баллов оформление вызывает отдельно, используя запросы/результаты из
`OrderPriceBreakdown`). Порядок:

1. **Позиции** собираются по активному меню точки: цена товара и модификаторов — серверная,
   модификатор обязан принадлежать группе своей позиции. Комбо фиксируется одной `OrderItem`
   по цене из `ComboPricing` (без модификаторов, без категории — категорийные скидки на комбо
   не действуют).
2. **Скидки** (`OrderPricingInterface`): промокод + автоакции + постоянная скидка уровня
   лояльности гостя. Флаг «первый заказ» = `!orders->hasPaidOrBeyondByCustomer(...)`.
3. **Баллы** (`OrderRewardsInterface->quoteRedeem`): списание идёт **поверх** скидок, от суммы
   к оплате после промо; `payable = subtotal − скидки − баллы` (не ниже нуля).

## 7. Read-model (`Query/OrderView`)

`OrderView::fromOrder()` — единый сборщик ответа: id, воркспейс/точка/клиент, тип, статус,
суммы (`subtotal_kopecks`, `discount_kopecks`, `points_discount_kopecks`, `total_kopecks`),
`points_spent`/`points_earned`, контакты, позиции с модификаторами и `line_total_kopecks`,
`estimated_wait_minutes` (ETA от домена `WaitTime`, также приходит в реалтайме) и историю
статусов. Все ответы Order используют его, чтобы форма заказа была одинаковой везде.

## 8. Хранилище и инфраструктура

- Doctrine-сущность `Infrastructure/Doctrine/Domain/Order/Order` + `OrderRepository`. Таблица
  называется `"order"` (в кавычках — зарезервированное слово PostgreSQL). `items`, `history`,
  `applied_discounts` хранятся JSON-колонками. Миграция `Version20260708160000`.
- Реалтайм — Mercure (`Infrastructure/Mercure/MercureOrderNotifier`, тема `orders/{id}`):
  публикуется при оплате и каждой смене статуса.
- Оплата заказов и подписок идёт на один вебхук `/pay`; заказ отличается маркером
  `Data.kind == "order"` (иначе — подписка). Выбор провайдера (CloudPayments/ЮKassa) —
  per-workspace через `OrderPaymentGatewayResolverInterface` (домен `Billing`).

## 9. Кроны

| Команда | Что делает |
|---------|-----------|
| `app:orders:expire-abandoned` (`--ttl`, дефолт 30 мин) | `ExpireAbandonedOrders`: отменяет неоплаченные Created старше TTL, в транзакции возвращает резерв баллов и откатывает скидки (репо `findAbandonedCreated`) |

## 10. Ограничения / TODO

- Статусы двигает **персонал вручную**; `SyncOrderStatusFromPos` — готовый идемпотентный вход,
  но самого поллера iiko Deliveries пока нет (M5.1).
- Возврат средств при отмене оплаченного заказа не реализован (откатываются только баллы/скидки).
- Плечо доставки в ETA — константа из `KitchenProfile`, без трекинга курьера (см. домен `WaitTime`).
- Флаг «первый заказ» считается по факту оплаченных заказов клиента в воркспейсе; брошенные
  Created в счёт не идут.
