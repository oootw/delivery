# План рефакторинга именования команд, запросов и репозиториев

> Цель: по короткому имени класса команды/запроса (и метода репозитория) сразу понятно,
> **что делает** и **что в него передаётся**. Убираем generic-классы `Command`/`Handler`/
> `Query`/`Fetcher` и алиасы в Action'ах.

## Решения (согласовано 2026-07-11)
- **Форма — полная:** папка use-case получает параметры в имени (где их не хватает),
  а все четыре роли классов переименовываются с описательным префиксом.
- **Объём:** use-case классы (Command/Query) **и** неочевидные методы репозиториев.

## Конвенция именования

### Классы use-case (роль — суффиксом)
| Было (класс) | Стало |
|---|---|
| `Command` | `{UseCase}Command` |
| `Handler` | `{UseCase}Handler` |
| `Query` | `{UseCase}Query` |
| `Fetcher` | `{UseCase}Fetcher` |

DTO/View уже описательны (`PlacedOrderDTO`, `PromotionView`, `OrderView`, `QuoteView`) — не трогаем.

### Папки use-case
- **Команды**: имя папки уже императивно-описательное (`PlaceOrder`, `CreatePromotion`,
  `ChangeOrderStatus`) — **папку не переименовываем**, только классы внутри.
- **Запросы**: имя папки должно кодировать параметр — `Get{Entity|Entities}By{Param}`,
  коллекция во множественном числе, идентификатор с суффиксом `Id`/`Ids`. Папку переименовываем,
  namespace меняется — обновляем всех, кто ссылается.

### Method-конвенция репозиториев (уточняем неочевидные)
- `find...` → nullable/коллекция, `get...` → бросает, `has/exists/count...` → bool/int.
- Добавляем `By{Param}`, где параметр не очевиден из имени. Уже корректные (`findActiveByUser`,
  `findByWorkspaceAndUser`, `hasPaidOrBeyondByCustomer`, `findAbandonedCreated`) — не трогаем.

### Action'ы
- Убираем `use ... as XxxFetcher` — импортируем описательный класс напрямую,
  инжектим по FQCN (автосвязывание не меняется).

## Таблица переименования запросов (папка → новая)

| Домен | Было | Стало |
|---|---|---|
| Authorize | FindUserByPhone | FindUserByPhone *(ок, только классы)* |
| Authorize | GetRefreshTokensAvailable | GetRefreshTokensAvailable *(ок)* |
| Authorize | GetSmsCode | GetSmsCode *(ок; семантику не меняем)* |
| Authorize | GetSmsCodeSendAvailable | GetSmsCodeSendAvailable *(ок)* |
| Authorize | GetSmsDailyLimitAvailable | GetSmsDailyLimitAvailable *(ок)* |
| Loyalty | GetLoyaltyAccount | GetLoyaltyAccountByCustomerId |
| Loyalty | GetLoyaltyHistory | GetLoyaltyHistoryByCustomerId |
| Menu | GetClientBanners | GetClientBannersByVenueId |
| Menu | GetClientCategories | GetClientCategoriesByVenueId |
| Menu | GetClientProduct | GetClientProductById |
| Menu | GetClientProducts | GetClientProductsByCategoryId |
| Menu | GetClientVenues | GetClientVenuesByWorkspaceId |
| Menu | GetMenu | GetMenuByVenueId |
| Order | GetMyOrders | GetOrdersByCustomerId |
| Order | GetOrder | GetOrderById |
| Order | GetVenueOrders | GetOrdersByVenueId |
| Order | QuoteOrder | QuoteOrder *(ок; command-подобный)* |
| Promotion | GetActivePromotions | GetActivePromotionsByVenueId |
| Promotion | GetPromotion | GetPromotionById |
| Promotion | GetPromotions | GetPromotionsByWorkspaceId |
| Subscription | GetCurrentSubscription | GetCurrentSubscriptionByUserId |
| Tarif | GetAllTarif | GetAllTarifs |
| Venue | GetVenue | GetVenueById |
| Venue | GetVenueLogo | GetVenueLogoByVenueId |
| Venue | GetVenuesByWorkspace | GetVenuesByWorkspaceId |
| WaitTime | EstimateWait | EstimateWait *(ок)* |
| Workspace | GetMyWorkspaces | GetWorkspacesByMemberUserId |

Команды (49) — папки без изменений, классы `{UseCase}Command`/`{UseCase}Handler`.

## Процесс на каждый домен (вертикальный срез)
1. Переименовать файлы классов (`git mv` при необходимости) + сам класс внутри.
2. Для запросов — при необходимости переименовать папку (namespace).
3. Обновить импорты/использования в Action'ах (убрать алиасы), консольных командах и
   кросс-ссылках между use-case.
4. `php bin/console lint:container` + `php vendor/bin/phpunit tests/Unit` → зелёные.
5. Отметить домен в прогрессе ниже.

## Прогресс
- [x] Promotion (эталонный срез) — 3 запроса (GetPromotionById/GetPromotionsByWorkspaceId/GetActivePromotionsByVenueId) + 7 команд + 10 Actions; lint+тесты зелёные
- [x] Loyalty — GetLoyaltyAccountByCustomerId/GetLoyaltyHistoryByCustomerId + 5 команд + 6 Actions + консоль; зелёные
- [x] Order — GetOrderById/GetOrdersByCustomerId/GetOrdersByVenueId/QuoteOrder + 6 команд + 7 Actions + webhook + консоль; зелёные
- [x] Menu — 6 клиентских запросов (ByVenueId/ByCategoryId/ById/ByWorkspaceId) + 8 команд + 14 Actions; зелёные
- [x] Venue — GetVenueById/GetVenueLogoByVenueId/GetVenuesByWorkspaceId + 5 команд + 8 Actions; зелёные
- [x] Workspace — переименовано; зелёные
- [x] Subscription — GetCurrentSubscriptionByUserId + 6 команд + 2 Actions + webhook + консоль; зелёные
- [x] PosIntegration — переименовано; зелёные
- [x] Authorize — 5 запросов + 5 команд (папки сохранены) + 5 Actions; зелёные
- [x] WaitTime — переименовано; зелёные
- [x] Tarif — переименовано; зелёные
- [x] Репо-методы (финальный проход) — нормализованы неочевидные: `getAll`→`getAllTarifs`, `findByUser`→`findAllByUserId` (Membership), `findByVenue`→`findByVenueId` (PosConnection, KitchenProfile). Остальные уже с `By{Param}`.

## Итог
Все 11 доменов + репо-проход завершены. Generic-классов `Command`/`Handler`/`Query`/`Fetcher` не осталось; алиасы в Action'ах убраны (кроме осмысленных сокращений в webhook и вынужденных при коллизии имён в консольных командах). Проверено: `cache:clear` OK, `lint:container` OK, `debug:router` 61 роут, 5 app-команд, `phpunit` 43 теста зелёные.
