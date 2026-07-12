# Домен PosIntegration — как работает

Домен подключает точку к внешней POS-системе (iiko, r_keeper) и **фоново импортирует** из неё
меню. Namespace `App\Application\PosIntegration\...`. Doctrine —
`App\Infrastructure\Doctrine\Domain\PosIntegration`, экшены — `App\Http\Action\PosIntegration`,
адаптеры провайдеров — `App\Infrastructure\Iiko` и т.п. Все пути относительны `backend/`.

Домен владеет **соединением** (`PosConnection`) и снимком меню из POS (`PosMenuSnapshot`),
но сам меню не хранит — импорт передаётся домену `Menu` (`MenuImporter`). Секреты POS
шифруются. Импорт идёт **асинхронно через Messenger** — HTTP-запрос только ставит задачу в
очередь.

## 1. Эндпоинты

Файрвол `api` (JWT), владелец воркспейса.

| Метод | Роут | Экшен | Назначение |
|-------|------|-------|-----------|
| POST | `/api/v1/venues/{venueId}/pos` | `ConnectPosAction` | Подключить/переконфигурировать POS |
| POST | `/api/v1/venues/{venueId}/pos/import` | `RequestMenuImportAction` | Поставить импорт меню в очередь (202) |

## 2. Карта компонентов

```
PosIntegration/
├─ Entity/PosConnection/
│  ├─ PosConnection          venueId, posSystem, apiLogin (шифруется), organizationId,
│  │                         externalMenuId, status, lastSyncedAt, lastError
│  │                         buildNew / reconfigure / markSynced / markFailed
│  ├─ PosSystemEnum          iiko | rkeeper
│  ├─ PosConnectionStatusEnum pending | connected | error
│  └─ PosConnectionRepositoryInterface  (шифрует apiLogin при сохранении)
│
├─ Gateway/                  порты + нормализованный снимок меню
│  ├─ PosMenuProviderInterface       supports(posSystem) / fetchMenu(connection): PosMenuSnapshot
│  ├─ PosMenuProviderRegistry        выбор провайдера по posSystem (tagged_iterator)
│  ├─ MenuImportQueueInterface       enqueue(posConnectionId) — постановка в очередь
│  └─ PosMenuSnapshot / PosCategory / PosItem / PosModifierGroup / PosModifier
│                            провайдер-независимый снимок меню
│
└─ Command/
   ├─ ConnectPos            создать/переконфигурировать соединение (владелец)
   ├─ RequestMenuImport     поставить импорт в очередь (синхронный вход)
   └─ ImportMenu            оркестрация импорта (фоновый обработчик Messenger)
```

**Порты и адаптеры:**

| Порт | Реализация |
|------|-----------|
| `PosMenuProviderInterface` | `Infrastructure/Iiko/IikoMenuProvider` (и будущий r_keeper), собираются в реестр по тегу `app.pos_menu_provider` |
| `MenuImportQueueInterface` | `Infrastructure/Messenger/MenuImport/MenuImportQueue` (`ImportMenuMessage` → транспорт `async`) |
| `PosConnectionRepositoryInterface` | `Infrastructure/Doctrine/Domain/PosIntegration` (шифрует `apiLogin` через `SecretCipher`) |

Миграция `Version20260708150000` (`pos_connection`). Env `IIKO_API_URL`.

## 3. Поток: подключение и импорт (асинхронный)

```
[1] POST /venues/{id}/pos → ConnectPos: buildNew/reconfigure соединения (секреты шифруются), status=pending
[2] POST /venues/{id}/pos/import → RequestMenuImport: MenuImportQueue->enqueue(connectionId) → 202 Accepted
        (HTTP-ответ отдаётся сразу, реальная работа — в фоне)
[3] Messenger (async) → ImportMenuHandler:
        ├─ providers->providerFor(posSystem)->fetchMenu(connection) → PosMenuSnapshot
        ├─ MenuImporter->import(venueId, snapshot)   (домен Menu: upsert по externalId + архив)
        ├─ успех → connection->markSynced()  (lastSyncedAt)
        └─ ошибка → connection->markFailed(error)  (status=error, lastError) + проброс (ретрай Messenger)
```

## 4. Снимок меню (`Gateway/PosMenuSnapshot`)

Провайдер приводит ответ POS к нормализованному снимку: категории (`PosCategory`), товары
(`PosItem`), группы модификаторов (`PosModifierGroup`) и модификаторы (`PosModifier`) —
независимо от конкретной POS. Дальше снимок потребляет `MenuImporter` домена `Menu` (upsert по
`externalId`, отсутствующие позиции архивируются, а не удаляются).

**iiko-адаптер** (`Infrastructure/Iiko/IikoMenuProvider`): сгенерированный `IIKO\`-клиент,
цепочка `api1AccessTokenPost → api2MenuByIdPost`; цены/модификаторы/БЖУ берутся из
`item_sizes` (первый размер) — требует проверки на реальном ответе.

## 5. Ограничения / TODO

- Реализован провайдер iiko; r_keeper — заложен enum'ом, адаптера пока нет.
- Разбор ответа iiko (первый размер, БЖУ, модификаторы) не проверен на боевом ответе.
- Обратной синхронизации (заказы в POS, статусы из POS) в этом домене нет — заложен только
  идемпотентный вход `SyncOrderStatusFromPos` в домене `Order` под будущий поллер.
