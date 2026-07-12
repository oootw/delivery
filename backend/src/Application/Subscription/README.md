# Домен Subscription — как работает

Домен ведёт **подписку владельца воркспейса** — рекуррентный платёж на платформу CloudPayments,
который даёт право владеть воркспейсами и принимать заказы. Namespace
`App\Application\Subscription\...` (прикладной слой). Doctrine — в
`App\Infrastructure\Doctrine\Domain\Subscription`, экшены — в `App\Http\Action\Subscription`.
Все пути относительны `backend/`.

**Право владельца = активная подписка** (`Subscription::isActive()`), отдельного флага нет.
Подписки — всегда платформенный **CloudPayments** (env-креды платформы, счёт платформы); это
не путать с оплатой заказов гостями, где провайдер выбирается per-workspace (домен `Billing`).
Без триала и грейс-периода.

## 1. Эндпоинты

Файрвол `api` (JWT). Подтверждение оплаты приходит на публичный вебхук CloudPayments
(домен `Billing`), не сюда.

| Метод | Роут | Экшен | Назначение |
|-------|------|-------|-----------|
| POST | `/api/v1/subscriptions` | `StartSubscriptionAction` | Начать подписку → реквизиты для оплаты |
| GET | `/api/v1/subscriptions/current` | `GetSubscriptionAction` | Текущая подписка пользователя |

## 2. Карта компонентов

```
Subscription/
├─ Entity/Subscription/
│  ├─ Subscription           агрегат (userId, tarifCode, status, invoiceId, externalId,
│  │                         currentPeriodEnd, lastPaymentTransactionId)
│  ├─ SubscriptionStatusEnum pending | active | past_due | canceled
│  └─ SubscriptionRepositoryInterface
│                            save/findById/findByInvoiceId/findByExternalId/
│                            findActiveByUser/findPendingByUser/findLatestByUser/findPastDueOlderThan
│
├─ Command/
│  ├─ StartSubscription             создать/переиспользовать pending → реквизиты оплаты
│  ├─ RecordSubscriptionPayment     провести платёж по вебхуку (идемпотентно по TransactionId)
│  ├─ MarkSubscriptionPastDue       рекуррент не прошёл → past_due
│  ├─ CancelSubscription            отмена подписки (+ отмена рекуррента в CloudPayments)
│  ├─ StopSubscription              остановка
│  └─ CancelStalePastDueSubscriptions  крон: гасит past_due старше грейса
│
└─ Query/
   └─ GetCurrentSubscriptionByUserId → SubscriptionDTO
```

Порт `SubscriptionRepositoryInterface` → `Infrastructure/Doctrine/Domain/Subscription`.
Отмена рекуррента и HMAC-вебхук — адаптер `Infrastructure/CloudPayments/CloudPaymentsGateway`
(порт `Shared/Contract/Payment/PaymentGateway/PaymentGatewayInterface`). Миграция
`Version20260708120000` (+ `Version20260711150000` — `lastPaymentTransactionId`).

## 3. Статусы

```
pending ──оплата(webhook)──▶ active ──рекуррент не прошёл──▶ past_due ──грейс истёк──▶ canceled
   │                            │
   └── отмена ──▶ canceled      └── отмена/остановка ──▶ canceled
```

- `pending` — создана, ждёт первого платежа;
- `active` — оплачена, право владельца действует (`isActive()`);
- `past_due` — рекуррентный платёж не прошёл (`MarkSubscriptionPastDue`);
- `canceled` — отменена вручную или кроном после грейса.

## 4. Поток: POST `/subscriptions` (старт)

`StartSubscriptionHandler`:

```
[1] тариф валиден и существует (TarifRepository->getByTarifCode)
[2] нет активной подписки у пользователя (findActiveByUser) — иначе \DomainException
[3] есть pending? переиспользуем её (changePendingTarif), НЕ плодим дубли; иначе buildNew
[4] save → отдаём реквизиты (invoiceId, priceKopecks, amountRubles) для виджета CloudPayments
```

Ответ (`StartedSubscriptionDTO`): id, invoiceId, тариф, цена. Первый платёж — виджетом на
фронте; подтверждение — вебхуком CloudPayments (`/pay` → `RecordSubscriptionPayment`).

## 5. Оплата и рекуррент

- **Подтверждение** (`RecordSubscriptionPayment`): вебхук `/pay` домена `Billing` различает
  подписку и заказ по маркеру `Data.kind` (нет `kind=="order"` → подписка). Идемпотентно
  по `TransactionId` (`lastPaymentTransactionId`): повторный вебхук — no-op.
- **Рекуррент**: последующие списания CloudPayments приходят на `/recurrent`; неуспех →
  `MarkSubscriptionPastDue`.
- **Отмена**: `CancelSubscription` шлёт `POST /subscriptions/cancel` (basic-auth) в
  CloudPayments + помечает `canceled`.

## 6. Кроны

| Команда | Что делает |
|---------|-----------|
| `app:subscriptions:cancel-past-due` (`--grace-days`, дефолт 3) | `CancelStalePastDueSubscriptions`: отменяет `past_due` старше грейса (репо `findPastDueOlderThan`) |

## 7. Ограничения / TODO

- Без триала и грейс-периода на старте; грейс есть только на `past_due` (3 дня до отмены).
- Дубли pending защищены переиспользованием (`findPendingByUser`); лимит тарифов — политика
  `Tarif/Service/TarifLimits` (см. домен `Tarif`).
- Возврат средств при отмене оплаченного периода не реализован.
