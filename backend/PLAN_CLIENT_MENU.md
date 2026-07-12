# План: клиентская витрина меню (Client Menu API)

Клиент сканирует QR → авторизуется по телефону (существующий домен `Authorize`, JWT) →
попадает на витрину меню бренда. Витрина — отдельные read-эндпоинты на каждую сущность,
все возвращают `id`. Плюс эндпоинты редактирования для новых данных (БЖУ, галерея, баннеры).

## Решения (2026-07-11)

- **Доступ клиента.** Эндпоинты под `/api/v1/menu/**` — JWT любого авторизованного
  пользователя, **без членства в воркспейсе** (в отличие от `requireMember` в staff-меню).
  Развязка — сервис `Application/Menu/Client/ClientMenuAccess` (резолвит воркспейс и
  проверяет принадлежность точки воркспейсу).
- **Воркспейс — по поддомену.** `slug.app.com` → `WorkspaceContext` (уже заполняется
  `WorkspaceContextListener`) → `WorkspaceRepository::findBySlug` → `workspaceId`.
  В dev slug берётся из заголовка `X-Workspace-Slug`.
- **Баннеры — из акций.** Не отдельная сущность: к `Promotion` добавляются баннерные поля
  (`bannerTitle`, `bannerText`) и картинка (storage). В витрину баннеров попадают активные
  автоматические акции точки, у которых загружена баннерная картинка.
- **БЖУ — POS-база + ручной оверрайд.** У товара базовое НО из POS (`posNutrition`, JSON,
  перезаписывается импортом), плюс ручной оверрайд владельца в отдельной таблице
  `menu_item_nutrition` (переживает импорт). Эффективное значение для клиента —
  пофилдовый мёрж (override.field ?? posBase.field).
- **Фото товара — галерея.** Несколько фото на товар: `menu-item-{id}-{n}.{ext}`.
  Остальные сущности — одиночное фото (как раньше). Витрина товара отдаёт список URL по
  порядку; если галерея пуста — фолбэк на POS-картинку.
- **Тип модификатора — выводится из min/max.** `display_type`: `radio` при max=1,
  иначе `checkbox`. Отдельного поля/эндпоинта нет.
- **Размеры порций — обычная группа модификаторов «Размер»** (radio с доплатами).
  Отдельной сущности ItemSize и правок в расчёт заказа не делаем.
- **Скидка на карточке товара.** Пер-товарных скидок в модели пока нет (акции — на заказ),
  поэтому `old_price_kopecks` в списке товаров = null до появления пер-товарных акций.
  Комбо отдаются отдельным списком со своей ценой/скидкой (см. GetMenu).

## Модель данных (изменения)

### Nutrition (новое)
- VO `Application/Menu/Nutrition/Nutrition` — `weightGrams`, `per100 {kcal,proteins,fats,carbs}`,
  `perPortion {kcal,proteins,fats,carbs}`; все nullable; `toArray/fromArray`, `merge()`.
- `MenuItem.posNutrition: ?Nutrition` — из POS (`applyFromPos`), JSON-колонка `pos_nutrition`.
- Сущность-оверрайд `Application/Menu/Entity/MenuItemNutrition/MenuItemNutrition`
  (`venueId`, `itemExternalId`, `Nutrition`) + репозиторий; таблица `menu_item_nutrition`
  (uniq venue_id+item_external_id). Импорт её не трогает.
- POS-снапшот: `PosItem` получает `?Nutrition`; `IikoMenuProvider` мапит НО из iiko
  (energyAmount/FullAmount и т.п.) — **требует проверки на реальном ответе**, при отсутствии null.

### Promotion (баннерные поля)
- `Promotion.bannerTitle: ?string`, `Promotion.bannerText: ?string` (миграция ALTER).
- Картинка баннера — storage `PromotionBannerStorage` (`promo-banner-{id}.{ext}`).
- Команда `SetPromotionBanner` (title/text) + Actions загрузки/удаления картинки.
- Репозиторий: `findActiveAutomaticByVenue` уже есть — в витрине фильтруем по наличию картинки.

### Галерея товара
- `MenuImageStorage` получает методы галереи: `findGalleryUrls`, `addToGallery`,
  `deleteFromGalleryIndex`, `galleryCount`. Файл `menu-item-{id}-{n}.{ext}`.

## Эндпоинты

### Клиентские (JWT, воркспейс из поддомена)
1. `GET /api/v1/menu/venues` — точки бренда: `[{id, name, address, latitude, longitude, phone, supports_delivery, supports_pickup}]`.
2. `GET /api/v1/menu/venues/{venueId}/banners` — `[{id, title, text, image_url}]` из активных акций с картинкой.
3. `GET /api/v1/menu/venues/{venueId}/categories` — `[{id, name, position, photo_url}]`.
4. `GET /api/v1/menu/venues/{venueId}/categories/{categoryId}/products` — карточки:
   `[{id, external_id, name, image_url, price_kopecks, old_price_kopecks, weight_g, kcal}]`.
5. `GET /api/v1/menu/venues/{venueId}/products/{itemId}` — деталка:
   `{id, external_id, name, description, images:[...], nutrition:{weight_g, per_100g:{...}, per_portion:{...}},
   modifier_groups:[{id, name, display_type, min_selection, max_selection, modifiers:[{id, name, price_kopecks}]}]}`.

### Владельца (редактирование новых данных)
- `PUT /api/v1/venues/{venueId}/menu/items/{itemId}/nutrition` — оверрайд БЖУ.
- `POST /api/v1/venues/{venueId}/menu/items/{itemId}/photos` — добавить фото в галерею (multipart `photo`).
- `DELETE /api/v1/venues/{venueId}/menu/items/{itemId}/photos/{index}` — удалить фото галереи.
- `PUT /api/v1/promotions/{promotionId}/banner` — заголовок/текст баннера.
- `POST /api/v1/promotions/{promotionId}/banner/image` — загрузить картинку баннера (multipart `image`).
- `DELETE /api/v1/promotions/{promotionId}/banner/image` — удалить картинку баннера.

## Статус (2026-07-11): реализовано, кроме миграций

Готово всё из плана. Проверки: `php -l` по всему `src`, `lint:container` OK, `cache:clear` OK,
роуты и Doctrine-маппинг зарегистрированы, юнит-проверка мёржа БЖУ пройдена.
**Пользователю:** применить миграции `Version20260711120000` (combo) и `Version20260711130000`
(pos_nutrition + menu_item_nutrition + promotion banner) — dev-БД (127.0.0.1:5466) была недоступна.
Маппинг БЖУ из iiko (`ExternalMenuItemSize::getNutritionPerHundredGrams/getNutritions/getPortionWeightGrams`)
**требует проверки на реальном ответе** (структура может отличаться; при отсутствии данных — null).

## Порядок реализации
1. Nutrition VO + MenuItem.posNutrition + миграция; оверрайд-сущность/таблица/репо.
2. POS-снапшот+iiko (НО) + MenuImporter (пробрасывает posNutrition, оверрайд не трогает).
3. Owner: PUT nutrition-оверрайд.
4. Галерея: storage-методы + owner-эндпоинты фото товара.
5. Promotion: баннерные поля + миграция + storage + owner-эндпоинты.
6. Клиентский доступ: `ClientMenuAccess` (slug→workspace, проверка точки).
7. Клиентские read-эндпоинты 1–5.
8. Проверки: `php -l`, `lint:container`, роуты, маппинг. Миграции применяет пользователь.
