# Домен WaitTime — как работает

Домен оценивает **время ожидания заказа** (сколько гостю ещё ждать) по настройкам кухни
точки, текущей нагрузке (очередь) и исторической скорости готовки. Namespace
`App\Application\WaitTime\...`. Doctrine — `App\Infrastructure\Doctrine\Domain\WaitTime`,
экшены — `App\Http\Action\WaitTime`. Все пути относительны `backend/`.

Домен — **реализация порта домена `Order`**: `WaitTimeRecalculator implements
WaitTimeRecalculatorInterface`. Order дёргает пересчёт при изменении нагрузки, ничего не
зная о формуле. Всё время — в целых минутах, «осталось ждать от текущего момента», не
меньше нуля.

## 1. Эндпоинты

Файрвол `api`. Настройка профиля — владелец; предварительная оценка — любой авторизованный.

| Метод | Роут | Экшен | Назначение |
|-------|------|-------|-----------|
| GET | `/api/v1/venues/{venueId}/wait-estimate` | `EstimateWaitAction` | Предварительная оценка по корзине (`type`, `units`) |
| PUT | `/api/v1/venues/{venueId}/kitchen-profile` | `SetKitchenProfileAction` | Задать настройки кухни точки |

Пересчёт по активным заказам — не эндпоинт: его вызывает домен `Order` (см. §4) и консольная
команда `app:wait-time:recalculate` (`RecalculateWaitTimesCommand`, по таймеру).

## 2. Карта компонентов

```
WaitTime/
├─ Entity/KitchenProfile/
│  ├─ KitchenProfile         venueId, baseMinutes, perUnitMinutes, parallelCapacity,
│  │                         deliveryMinutes; buildDefault (10/4/3/30) когда не настроено
│  └─ KitchenProfileRepositoryInterface
│
├─ Service/
│  ├─ WaitTimeEstimator      чистая формула: estimateWaitMinutes(WaitTimeInputs) → int (см. §3)
│  ├─ WaitTimeInputs         согласованный вход формулы (status, type, units, profile,
│  │                         queueAhead, elapsedCookingMinutes, historicalPerUnitMinutes)
│  ├─ KitchenHistory         историческая калибровка: среднее факт. время/единицу (paid→ready)
│  │                         по недавним заказам; < MIN_SAMPLES(5) → null
│  └─ WaitTimeRecalculator   адаптер WaitTimeRecalculatorInterface: пересчёт всех активных
│                            заказов точки + рассылка гостям (realtime)
│
├─ Command/SetKitchenProfile     задать/обновить профиль кухни (владелец)
└─ Query/EstimateWait            предварительная оценка до оформления → int минут
```

**Порты и адаптеры:** `KitchenProfileRepositoryInterface` →
`Infrastructure/Doctrine/Domain/WaitTime`; порт заказа `WaitTimeRecalculatorInterface` (в
домене `Order`) реализует `WaitTimeRecalculator` (alias в `services.yaml`). Таблица
`kitchen_profile` — миграция `Version20260708170000`.

## 3. Формула (`Service/WaitTimeEstimator`)

Договорённость 2026-07-08, чистая функция от `WaitTimeInputs`:

1. **Своё время готовки** = `baseMinutes + perUnit × units`, где `perUnit` — смесь настроенного
   и исторического: `0.5 × historical + 0.5 × configured` (если истории нет — только
   configured).
2. **Очередь** = `(queueAhead ÷ parallelCapacity) × своё время готовки` — чем выше нагрузка
   кухни, тем дольше.
3. **По статусу**: до готовки (`created`/`paid`/`accepted`) — очередь + вся своя готовка; в
   готовке (`cooking`) — только остаток `own − elapsed`; после (`ready`/`on_the_way`/
   терминальные) — кухонное время = 0.
4. **Доставка**: к кухонному времени прибавляется логистическое плечо `deliveryMinutes`
   (обнуляется только на `completed` — точного положения курьера пока нет); самовывоз — без
   плеча.

Итог — `ceil(max(0, cook + delivery))`.

## 4. Интеграция с заказом

`WaitTimeRecalculator.recalculateForVenue(venueId)` перебирает активные заказы точки
(`findInProgressByVenue`), считает `queueAhead` по заказам, уже принятым в работу
(`accepted`/`cooking`, вставшим раньше), применяет оценку (`Order::applyWaitEstimate`),
сохраняет и рассылает статус гостю (`OrderRealtimeNotifierInterface`).

Пересчёт триггерят хендлеры домена `Order` при изменении нагрузки: `PlaceOrder`,
`RecordOrderPayment`, `ChangeOrderStatus`, `CancelOrder`, `SyncOrderStatusFromPos`,
`ExpireAbandonedOrders`, плюс таймер (`app:wait-time:recalculate`).

`EstimateWait` (витрина корзины) считает как для нового заказа (`status=created`) с текущей
очередью кухни — отдельно от пересчёта активных.

## 5. Ограничения / TODO

- Плечо доставки держится полным до `completed` — без трекинга курьера не уменьшаем на
  `on_the_way`.
- Историческая калибровка включается только при ≥ 5 замерах (`paid`→`ready`), иначе формула
  опирается на настройки точки.
