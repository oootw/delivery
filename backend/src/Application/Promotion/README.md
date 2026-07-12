# Домен Promotion — как работает

Домен считает **скидки и промокоды**: акция и промокод — это два типа одной сущности
`Promotion`, а применение к заказу выполняет чистый `PromotionEngine` со стекингом.
Namespace `App\Application\Promotion\...`. Doctrine — `App\Infrastructure\Doctrine\Domain\Promotion`,
экшены — `App\Http\Action\Promotion`. Все пути относительны `backend/`.

Домен — **реализация порта ценообразования домена `Order`**: `PromotionPricing implements
OrderPricingInterface`. Order вызывает его при оформлении и предпросмотре, ничего не зная о
внутренностях промо. Деньги — в копейках, проценты — в базисных пунктах (int).

## 1. Эндпоинты

Файрвол `api`. Мутации — владелец; гостевая витрина — любой авторизованный.

| Метод | Роут | Экшен | Назначение |
|-------|------|-------|-----------|
| POST | `/api/v1/workspaces/{workspaceId}/promotions` | `CreatePromotionAction` | Создать акцию/промокод |
| GET | `/api/v1/workspaces/{workspaceId}/promotions` | `GetPromotionsAction` | Список (владелец) |
| GET | `/api/v1/promotions/{promotionId}` | `GetPromotionAction` | Одна акция |
| PUT | `/api/v1/promotions/{promotionId}` | `UpdatePromotionAction` | Изменить |
| DELETE | `/api/v1/promotions/{promotionId}` | `DeletePromotionAction` | Удалить |
| POST | `/api/v1/promotions/{promotionId}/activation` | `ChangePromotionActivityAction` | Вкл/выкл |
| GET | `/api/v1/venues/{venueId}/promotions` | `GetActivePromotionsAction` | Витрина: активные автоакции (без кода/лимитов) |
| PUT | `/api/v1/promotions/{promotionId}/banner` | `SetPromotionBannerAction` | Текст баннера |
| POST | `/api/v1/promotions/{promotionId}/banner/image` | `UploadPromotionBannerAction` | Картинка баннера |
| DELETE | `/api/v1/promotions/{promotionId}/banner/image` | `DeletePromotionBannerAction` | Убрать картинку |

## 2. Карта компонентов

```
Promotion/
├─ Entity/Promotion/
│  ├─ Promotion            workspaceId, venueId?, type, code?, rewardType/rewardValue, target/targetRefs,
│  │                       conditions, priority, stackable, maxRedemptions(+PerCustomer), isActive, banner
│  │                       discountFor(context) / isPromocode / isExhausted / registerRedemption
│  ├─ PromotionTypeEnum    automatic | promocode
│  ├─ RewardTypeEnum       percent (б.п.) | fixed_amount (коп.)
│  ├─ PromotionTargetEnum  order | item | category  (targetRefs = externalId позиций/категорий)
│  ├─ PromotionConditions  VO: minTotal, orderTypes, daysOfWeek(1-7), timeFrom/timeTo (happy-hours),
│  │                       firstOrderOnly, validFrom/validTo
│  ├─ PromotionContext / CartLine    вход движка (зеркала OrderPricingRequest/PricingLine)
│  ├─ PromotionResult / AppliedPromotion   результат применения
│  └─ PromotionRedemption  учёт списаний (лимиты)
│
├─ Service/
│  ├─ PromotionEngine      чистый: apply(candidates, context) → PromotionResult (стекинг, см. §3)
│  └─ PromotionPricing     адаптер OrderPricingInterface: priceOrder / recordApplied / revertApplied
│
├─ Command/                CreatePromotion / UpdatePromotion / ChangePromotionActivity / DeletePromotion
│  └─ SetPromotionBanner / UploadPromotionBanner / DeletePromotionBanner
│
├─ Query/                  GetPromotionById / GetPromotionsByWorkspaceId → PromotionView
│  └─ GetActivePromotionsByVenueId → PublicPromotionView (без кода/лимитов/счётчиков)
│
└─ Banner/PromotionBannerStorageInterface   картинка баннера (promo-banner-{id})
```

**Порты и адаптеры:** `PromotionRepositoryInterface` → `Infrastructure/Doctrine/Domain/Promotion`;
порт заказа `OrderPricingInterface` (в домене `Order`) реализует `PromotionPricing` (alias в
`services.yaml`). Миграции `Version20260709120000` (promotion, promotion_redemption + колонки
order), `Version20260709130000` (venue.timezone для happy-hours).

## 3. Движок стекинга (`Service/PromotionEngine`)

`apply(candidates, context)`:

1. кандидаты сортируются по `priority`;
2. пока правило `stackable` — скидки **суммируются**; наткнулись на нестекируемое (эксклюзив) —
   берётся best-only (лучшая одна);
3. итог ограничен потолком `MIN_PAYABLE_KOPECKS = 100` — 100%-скидку не допускаем.

База скидки зависит от `target`: `order` — весь subtotal; `item`/`category` — сумма подходящих
строк заказа (`Promotion::discountBase`, фикс на подмножество — раз на заказ).

**Условия** (`PromotionConditions`) проверяются перед применением: минимальная сумма, тип
заказа, дни недели, happy-hours (окно `timeFrom`–`timeTo`, в т.ч. через полночь, **по таймзоне
точки**), «только первый заказ» (`isFirstOrder` = нет оплаченных заказов клиента), окно
`validFrom`/`validTo`. Скидка **уровня лояльности** (домен `Loyalty`) добавляется движком
поверх промо отдельной виртуальной строкой (`promotion_id = 0`, в леджер не пишется).

## 4. Интеграция с заказом

`PromotionPricing`:

- `priceOrder(OrderPricingRequest)` → `OrderPricingResult` — вызывается из `OrderPriceCalculator`
  (оформление и quote);
- `recordApplied(orderId, ...)` — при оформлении фиксирует применённые скидки в леджере
  (`promotion_redemption`) и счётчики лимитов (`registerRedemption`); виртуальная скидка уровня
  (id=0) в леджер не пишется;
- `revertApplied(orderId)` — при отмене заказа откатывает счётчики.

Промокоды: `UPPER` + trim, невалидный код → `400`. Витрина (`GetActivePromotions`) отдаёт только
активные `automatic`-акции — промокоды скрыты.

## 5. Баннеры

Активные автоакции с картинкой попадают в клиентскую витрину (домен `Menu`,
`GetClientBanners`): `Promotion` несёт `bannerTitle`/`bannerText` (`setBanner`) + картинку через
`PromotionBannerStorageInterface` (`promo-banner-{id}`, хранилище `public/upload/{slug}/`).

## 6. Ограничения / TODO

- Пер-товарных скидок в карточке нет (`old_price_kopecks = null`); скидки считаются на заказ.
- Фикс-скидка на подмножество (item/category) применяется раз на заказ, не построчно с
  количеством.
- Уровневая скидка лояльности идёт через этот же движок как строка `promotion_id = 0`.
