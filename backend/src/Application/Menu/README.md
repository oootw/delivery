# Домен Menu — как работает

Домен хранит и отдаёт **меню точки**: категории, товары, группы модификаторов, модификаторы,
комбо, БЖУ и фото. Обслуживает две аудитории — персонал (управление меню) и клиента
(витрина по QR). Namespace `App\Application\Menu\...`. Doctrine —
`App\Infrastructure\Doctrine\Domain\Menu`, экшены — `App\Http\Action\Menu` (+ `Menu/Client`).
Все пути относительны `backend/`.

Меню импортируется из POS (домен `PosIntegration` вызывает `MenuImporter`) — большинство
сущностей имеют `externalId` и логику архивации. Исключение — **Combo**, первая не-POS
сущность (создаётся владельцем вручную). Мультитенантность — по точке (`venue_id`) / воркспейсу.

## 1. Эндпоинты

### Управление меню (персонал, файрвол `api`)

| Метод | Роут | Экшен | Назначение |
|-------|------|-------|-----------|
| GET | `/api/v1/venues/{venueId}/menu` | `GetMenuAction` | Полное меню точки (категории + комбо) |
| POST | `/api/v1/venues/{venueId}/combos` | `CreateComboAction` | Создать комбо |
| PUT | `/api/v1/combos/{comboId}` | `UpdateComboAction` | Изменить комбо |
| DELETE | `/api/v1/combos/{comboId}` | `ArchiveComboAction` | Архивировать комбо |
| PUT | `/api/v1/venues/{venueId}/menu/items/{itemId}/nutrition` | `SetMenuItemNutritionAction` | Оверрайд БЖУ товара |
| POST | `/api/v1/venues/{venueId}/menu/items/{itemId}/photos` | `AddMenuItemPhotoAction` | Добавить фото в галерею товара |
| DELETE | `/api/v1/venues/{venueId}/menu/items/{itemId}/photos/{index}` | `DeleteMenuItemPhotoAction` | Удалить фото из галереи |
| POST | `/api/v1/venues/{venueId}/menu-images/{kind}/{id}` | `UploadMenuImageAction` | Загрузить одиночное фото сущности |
| DELETE | `/api/v1/venues/{venueId}/menu-images/{kind}/{id}` | `DeleteMenuImageAction` | Удалить одиночное фото |

### Клиентская витрина (файрвол `api`, JWT любого пользователя — **без членства**)

| Метод | Роут | Экшен | Назначение |
|-------|------|-------|-----------|
| GET | `/api/v1/menu/venues` | `GetClientVenuesAction` | Точки воркспейса (по slug-поддомену) |
| GET | `/api/v1/menu/venues/{venueId}/banners` | `GetClientBannersAction` | Баннеры (из акций) |
| GET | `/api/v1/menu/venues/{venueId}/categories` | `GetClientCategoriesAction` | Категории витрины |
| GET | `/api/v1/menu/venues/{venueId}/categories/{categoryId}/products` | `GetClientProductsAction` | Товары категории |
| GET | `/api/v1/menu/venues/{venueId}/products/{itemId}` | `GetClientProductAction` | Карточка товара |

## 2. Карта компонентов

```
Menu/
├─ Entity/
│  ├─ Category/         Category (externalId, applyFromPos, archive) + repo
│  ├─ MenuItem/         MenuItem (цена, modifierGroupExternalIds[], posNutrition, isAvailable) + repo
│  ├─ ModifierGroup/    ModifierGroup + repo
│  ├─ Modifier/         Modifier (цена) + repo
│  ├─ MenuItemNutrition/ оверрайд БЖУ (переживает импорт) + repo
│  └─ Combo/            Combo + ComboItem{itemExternalId,quantity} + ComboDiscountTypeEnum(percent|fixed) + repo
│
├─ Command/            (владелец)
│  ├─ CreateCombo / UpdateCombo / ArchiveCombo
│  ├─ SetMenuItemNutrition
│  ├─ AddMenuItemPhoto / DeleteMenuItemPhoto      галерея товара (до 8)
│  └─ UploadMenuImage / DeleteMenuImage           одиночное фото прочих сущностей
│
├─ Query/
│  ├─ GetMenuByVenueId → {categories, combos}     staff-меню
│  └─ Client/*  GetClientVenues/Banners/Categories/Products/Product   витрина
│
├─ Service/
│  ├─ MenuImporter      upsert по externalId + архив отсутствующих (в транзакции)
│  ├─ ComboPricing → ComboPrice   цена комбо = сумма товаров − скидка (недоступен товар → комбо недоступно)
│  └─ ComboItemsGuard   валидация состава комбо
│
├─ Client/
│  ├─ ClientMenuAccess       workspaceBySlug / venueOfWorkspace (доступ витрины)
│  └─ ClientProductAssembler effectiveNutrition / images / displayKcal
│
├─ Image/     MenuImageStorageInterface + MenuImageEntityLocator + MenuImageKind (category|item|modifier-group|modifier|combo)
└─ Nutrition/ Nutrition + NutritionFacts (VO БЖУ)
```

Порты репозиториев → `Infrastructure/Doctrine/Domain/Menu`. Миграции `Version20260708150000`
(база меню), `Version20260711120000` (combo), `Version20260711130000` (галерея/БЖУ-оверрайд).

## 3. Импорт из POS (`Service/MenuImporter`)

Вызывается доменом `PosIntegration` (`ImportMenu` → `MenuImporter->import(venueId, snapshot)`).
**Upsert по `externalId`** для категорий, товаров, групп модификаторов, модификаторов;
отсутствующие в снимке позиции **архивируются** (`isArchived`, не удаляются). Весь импорт — в
одной транзакции (`TransactionInterface`), N коммитов свёрнуты в 1 (батчинг). БЖУ из POS
кладётся в `MenuItem.posNutrition`.

## 4. Комбо (`Entity/Combo`, `Service/ComboPricing`)

Продаваемая сущность, создаётся владельцем вручную (`externalId` = UUID, есть archive-логика на
будущий импорт). Состав — **фиксированный набор** `ComboItem{itemExternalId, quantity}`. Цена
= **сумма товаров минус скидка** (`ComboPricing`): `percent`/`fixed`; если хоть один товар
недоступен/архивен — комбо недоступно. Комбо заказываемо (домен `Order` фиксирует его одной
`OrderItem` по серверной цене).

## 5. БЖУ и фото

- **БЖУ**: POS-база + ручной оверрайд, пофилдовый мёрж — `effectiveNutrition =
  (posNutrition ?? empty).merge(override)`. Оверрайд (`menu_item_nutrition`) переживает импорт.
  VO `Nutrition`/`NutritionFacts` (weight, per100/perPortion × kcal/proteins/fats/carbs).
- **Фото товара — галерея** (`menu-item-{id}-{n}`, до 8) через `MenuImageStorage`; приоритет в
  выдаче: **POS-картинка важнее загруженной** (`image_url = item.imageUrl ?? перваяГалерея`).
- **Фото прочих сущностей** — одиночное (`menu-{kind}-{id}.{ext}`), generic use-case
  `UploadMenuImage`/`DeleteMenuImage`; принадлежность точке проверяет `MenuImageEntityLocator`.
- Хранилище — `public/upload/{slug}/`, отдаётся веб-сервером по URL (порт
  `MenuImageStorageInterface` → `Infrastructure/Storage/MenuImageStorage`).

## 6. Клиентская витрина (`Client/`)

Клиент по QR → авторизация по телефону (домен `Authorize`) → витрина. Отдельные read-эндпоинты
`/api/v1/menu/**` доступны **любому** авторизованному, **без членства** в воркспейсе (в отличие
от staff `GetMenu`, требующего `requireMember`). Воркспейс определяется по slug-поддомену
(`WorkspaceContext.getSlug` → `WorkspaceRepository.findBySlug`); `ClientMenuAccess` проверяет,
что точка принадлежит воркспейсу. Баннеры собираются из активных автоакций с картинкой (домен
`Promotion`). Тип модификатора выводится из `max_selection` (radio=1 / checkbox иначе).

## 7. Ограничения / TODO

- Разбор БЖУ/цен/модификаторов из iiko не проверен на боевом ответе (см. домен `PosIntegration`).
- Пер-товарных скидок нет: акции действуют на заказ, в карточке `old_price_kopecks = null`.
- Combo — единственная не-POS сущность; archive-логика заложена, но импорта комбо из POS нет.
