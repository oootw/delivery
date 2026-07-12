# Домен Billing — как работает

Домен отвечает за **платёжные настройки воркспейса** (какой провайдер и мерчант-креды
использовать для оплаты заказов гостями) и приём **вебхуков** платёжных систем. Namespace
`App\Application\Billing\...`. Doctrine — `App\Infrastructure\Doctrine\Domain\Billing`,
экшены — `App\Http\Action\Billing`. Все пути относительны `backend/`.

Ключевое разделение потоков оплаты:

- **Подписки владельца** — всегда платформенный **CloudPayments** (env-креды платформы, счёт
  платформы). См. домен `Subscription`.
- **Оплата заказов гостями** — провайдер выбирается **на уровне воркспейса**; владелец вводит
  **свои** мерчант-креды (CloudPayments или ЮKassa). Это и есть предмет `WorkspacePaymentSettings`.

## 1. Эндпоинты

| Метод | Роут | Экшен | Файрвол | Назначение |
|-------|------|-------|---------|-----------|
| PUT | `/api/v1/workspaces/{workspaceId}/payment-settings` | `SetWorkspacePaymentSettingsAction` | `api` (владелец) | Задать провайдера + креды |
| GET | `/api/v1/workspaces/{workspaceId}/payment-settings` | `GetWorkspacePaymentSettingsAction` | `api` | Прочитать (без секретов) |
| POST | `/api/v1/webhooks/cloudpayments/{type}` | `CloudPaymentsWebhookAction` | `webhooks` (публичный) | Вебхук CloudPayments (pay/fail/recurrent) |
| POST | `/api/v1/webhooks/yookassa` | `YooKassaWebhookAction` | `webhooks` (публичный) | Вебхук ЮKassa |

## 2. Карта компонентов

```
Billing/
├─ Entity/WorkspacePaymentSettings/
│  ├─ WorkspacePaymentSettings   provider + зашифрованные credentials + isActive (одна на воркспейс)
│  └─ WorkspacePaymentSettingsRepositoryInterface
├─ Command/
│  └─ SetWorkspacePaymentSettings   владелец задаёт провайдера + креды (валидация по провайдеру)
└─ Query/
   └─ GetWorkspacePaymentSettings → WorkspacePaymentSettingsView (provider / is_active /
                                     credentials_set — секреты НЕ отдаёт)
```

**Контракт платежей — в `Shared/Contract/Payment/`** (провайдер-независимый, вне домена):

| Контракт | Назначение | Адаптеры |
|----------|-----------|----------|
| `PaymentProviderEnum` | `cloudpayments` \| `yookassa`, `requiredCredentialKeys()` | — |
| `PaymentGateway/PaymentGatewayInterface` | подписки владельца | `Infrastructure/CloudPayments/CloudPaymentsGateway` |
| `OrderPaymentGateway/OrderPaymentGatewayInterface` + `...ResolverInterface::forWorkspace(id)` | создать оплату заказа | `CloudPaymentsOrderGateway`, `YooKassaOrderGateway` |
| `OrderPaymentGateway/OrderPaymentStatusResolverInterface` | перезапрос статуса (у ЮKassa нет HMAC) | `YooKassaPaymentStatusResolver` |

Выбор адаптера по воркспейсу — `Infrastructure/Payment/WorkspaceOrderPaymentGatewayFactory`:
настройка неактивна/отсутствует → платформенный CloudPayments по env; иначе — адаптер с
кредами воркспейса. Креды шифруются `SecretCipher` (libsodium), в БД — JSON-колонка.
Миграция `Version20260712130000`.

## 3. Поток: PUT `/workspaces/{id}/payment-settings`

`SetWorkspacePaymentSettingsHandler`: `WorkspaceAccess::getOwnedWorkspace` (только владелец) →
валидация набора кредов по провайдеру (`requiredCredentialKeys()`: CloudPayments —
`public_id`+`api_secret`, ЮKassa — `shop_id`+`secret_key`) → шифрование → сохранение (одна
запись на воркспейс). GET-версия секреты не возвращает, только `provider`/`is_active`/
`credentials_set`.

## 4. Вебхуки

- **CloudPayments** (`/webhooks/cloudpayments/{type}`): типы `pay`/`fail`/`recurrent`; HMAC
  проверяется по base64 в заголовке `Content-HMAC`. `/pay` различает заказ и подписку по
  маркеру `Data.kind == "order"` → `RecordOrderPayment` (домен Order) либо
  `RecordSubscriptionPayment` (домен Subscription).
- **ЮKassa** (`/webhooks/yookassa`): подписи нет — берём `object.id` + `metadata.workspace_id`,
  **перезапрашиваем статус** через `OrderPaymentStatusResolverInterface->fetchStatus` (GET
  `/payments/{id}` кредами воркспейса); при `succeeded` + `orderId` → `RecordOrderPayment`.
  Ответ: `200` — обработано / нечего делать / бизнес-исход (не ретраим); `500` — транзиентная
  ошибка (ЮKassa повторит).

Оба файрвола `^/api/v1/webhooks` — публичные и stateless.

## 5. Ограничения / TODO

- Возврат/отмена платежа при отмене оплаченного заказа не реализованы **ни для одного**
  провайдера (общий долг — делать сразу для обоих отдельным срезом).
- Сумма платежа при подтверждении не сверяется с `payable` (snapshot есть, сверки нет).
- e2e-прогон вебхуков требует тест-БД / песочницы провайдеров (долг M7).
- ЮKassa — embedded-виджет через `confirmation_token`; CloudPayments — виджет без вызова API
  на этапе создания платежа.
