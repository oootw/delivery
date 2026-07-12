# Домен Loyalty — как работает

Домен ведёт **бонусную программу**: кэшбэк баллами, оплату заказа баллами, уровни гостя по
сумме трат и карту штампов. Namespace `App\Application\Loyalty\...`. Doctrine —
`App\Infrastructure\Doctrine\Domain\Loyalty`, экшены — `App\Http\Action\Loyalty`. Все пути
относительны `backend/`.

Домен — **реализация порта наград домена `Order`**: `OrderRewards implements
OrderRewardsInterface`. Order дёргает его по жизненному циклу заказа (котировка списания,
резерв, финализация, начисление, откат), ничего не зная о внутренностях лояльности. Деньги —
в копейках, ставки/проценты — в базисных пунктах (int), начисления округляются вниз.

## 1. Эндпоинты

Файрвол `api`. Настройки программы/уровней/штампов и ручная корректировка — владелец;
кошелёк и история — сам гость (по JWT).

| Метод | Роут | Экшен | Назначение |
|-------|------|-------|-----------|
| PUT | `/api/v1/workspaces/{workspaceId}/loyalty/program` | `SetLoyaltyProgramAction` | Настроить кэшбэк-программу |
| PUT | `/api/v1/workspaces/{workspaceId}/loyalty/tiers` | `SetLoyaltyTiersAction` | Задать уровни |
| PUT | `/api/v1/workspaces/{workspaceId}/loyalty/stamp-program` | `SetStampProgramAction` | Настроить карту штампов |
| POST | `/api/v1/workspaces/{workspaceId}/loyalty/adjust` | `AdjustLoyaltyBalanceAction` | Ручная корректировка баланса гостя |
| GET | `/api/v1/loyalty/account` | `GetLoyaltyAccountAction` | Кошелёк гостя: баланс, уровень, штампы |
| GET | `/api/v1/loyalty/history` | `GetLoyaltyHistoryAction` | История движений баллов |

Есть и админ-CRUD (EasyAdmin): `LoyaltyProgramCrudController`, `LoyaltyTierCrudController`,
`LoyaltyTransactionCrudController`.

## 2. Карта компонентов

```
Loyalty/
├─ Entity/
│  ├─ Program/LoyaltyProgram        одна на воркспейс: isEnabled, earnRate(б.п.),
│  │                                pointValueKopecks(курс балла), redeemMaxPercent(б.п.),
│  │                                pointsLifetimeDays; earnPointsFor / redeemablePoints
│  ├─ Account/LoyaltyAccount        кошелёк гостя: pointsBalance, reservedPoints,
│  │                                lifetimeSpentKopecks, currentTierId; reserve/finalize/
│  │                                release/earn/expire/refund/recordSpend/adjust
│  ├─ Tier/LoyaltyTier              уровень: thresholdKopecks, earnRateBonus(б.п.),
│  │                                permanentDiscount(б.п.), sortOrder
│  ├─ Stamp/StampProgram            одна на воркспейс: requiredCount, rewardPoints
│  ├─ Stamp/StampProgress           прогресс гостя по карте штампов (currentStamps)
│  ├─ Redemption/LoyaltyRedemption  списание по заказу + ЖЦ (Reserved→Finalized→Refunded/
│  │                                Released); один заказ — одна запись
│  └─ Transaction/LoyaltyTransaction леджер: Earn/RedeemFinalize/Refund/ManualAdjust/
│                                    StampReward/Expire, points + balanceAfter
│
├─ Service/
│  ├─ OrderRewards          адаптер OrderRewardsInterface (см. §3–4)
│  ├─ TierResolver          чистый: уровень по сумме трат + nextTier (прогресс)
│  └─ PointsExpiryCalculator FIFO-сгорание баллов по сроку жизни
│
├─ Command/                 SetLoyaltyProgram / SetLoyaltyTiers / SetStampProgram /
│  └─ AdjustLoyaltyBalance / ExpirePoints (консоль)
│
└─ Query/                   GetLoyaltyAccountByCustomerId (кошелёк+уровень+штампы) /
                            GetLoyaltyHistoryByCustomerId (леджер)
```

**Порты и адаптеры:** каждая сущность — свой `*RepositoryInterface` →
`Infrastructure/Doctrine/Domain/Loyalty`; порт заказа `OrderRewardsInterface` (в домене
`Order`, DTO `RedeemQuoteRequest`/`RedeemQuoteResult`/`TierDiscount`) реализует `OrderRewards`
(alias в `services.yaml`). Таблицы: `loyalty_program`/`loyalty_account`/`loyalty_redemption`/
`loyalty_transaction` (`Version20260709140000`), `loyalty_tier` + колонки уровня в account
(`Version20260710120000`), `stamp_program`/`stamp_progress` (`Version20260710130000`),
уникальный частичный индекс `uniq_loyalty_earn_per_order` (`Version20260711140000`).

## 3. Списание баллов (оплата заказа баллами)

Порт `OrderRewards` в связке с `Order`:

- `quoteRedeem(req)` → сколько баллов реально спишется и на сколько копеек: минимум из
  желаемого, доступного баланса (`availablePoints`) и лимита `redeemMaxPercent` от базы,
  причём итог к оплате не опускается ниже `MIN_PAYABLE_KOPECKS = 100`.
- `reserveOnPlace(orderId, req, res)` — при оформлении **резервирует** баллы под строку
  кошелька с блокировкой (`getOrCreateForUpdate`): конкурентный заказ дождётся коммита и не
  зарезервирует больше доступного; создаёт `LoyaltyRedemption` (Reserved).
- `finalizeOnPaid(orderId)` — при оплате резерв превращается в фактическое списание
  (`finalizeReserve`), redemption → Finalized, в леджер пишется `RedeemFinalize` (−points).
- `releaseOnCancel(...)` — при отмене: Reserved → просто снять резерв; Finalized → вернуть
  баллы (`refund`) + запись `Refund`.

## 4. Начисление, уровни и штампы

`accrueOnCompleted(orderId, workspaceId, customerId, netPaidKopecks)` — при **завершении**
заказа, идемпотентно:

- идемпотентность держит уникальный индекс `(order_id) WHERE type='earn'`: маркер `Earn`
  пишется всегда (даже при нулевом кэшбэке) и коротит все эффекты при повторе; гонку отсекает
  констрейнт (accrue выполняется в транзакции);
- **траты и уровень** копятся независимо от кэшбэка: `recordSpend` → `TierResolver.resolve`
  по `lifetimeSpentKopecks` → `setTier`;
- **кэшбэк** (если программа включена): `earnPointsFor(netPaid, tier.earnRateBonus)` —
  ставка с прибавкой уровня, потолок 100%;
- **штампы**: каждый завершённый заказ = +1 штамп; при наборе `requiredCount` начисляется
  `rewardPoints` на кошелёк (переполнение остаётся на следующую карту), запись `StampReward`.

**Постоянная скидка уровня** — `currentTierDiscount(workspaceId, customerId)` →
`TierDiscount(permanentDiscountBasisPoints, name)`; её применяет движок домена `Promotion`
поверх промо отдельной виртуальной строкой (`promotion_id = 0`, в леджер не пишется).

Откат начисления (`reverseAccrual` внутри `releaseOnCancel`) при отмене ранее завершённого
заказа урезает траты/уровень; сейчас недостижим (статус `completed` финальный), но корректен
на будущее. Начисленный кэшбэк при отмене у гостя не отзывается.

## 5. Сгорание баллов

`app:loyalty:expire-points` (`ExpireLoyaltyPointsCommand` → `ExpirePointsHandler`,
`PointsExpiryCalculator`) сжигает по FIFO баллы старше `pointsLifetimeDays` и не потраченные;
списывает только из доступных (резерв не трогает), пишет `Expire` в леджер.

## 6. Ограничения / TODO

- Уровневая скидка идёт через движок `Promotion` строкой `promotion_id = 0` (см. домен
  Promotion §3).
- Резерв/освобождение баланс не меняют и живут в `LoyaltyRedemption`, а не в леджере
  транзакций.
- Сгорание — FIFO по сроку жизни; при `pointsLifetimeDays = null` баллы бессрочны.
