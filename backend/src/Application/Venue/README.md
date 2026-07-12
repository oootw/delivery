# Домен Venue — как работает

Домен моделирует **точку продаж** внутри воркспейса: адрес, гео, телефон, режимы обслуживания
(доставка/самовывоз), часы работы, активность и логотип. Namespace `App\Application\Venue\...`.
Doctrine — `App\Infrastructure\Doctrine\Domain\Venue`, экшены — `App\Http\Action\Venue`. Все
пути относительны `backend/`.

Точка принадлежит воркспейсу (`workspace_id`). Создавать и менять её может **только владелец**
воркспейса, просматривать — любой участник. Часы работы и активность точки — вход для расчёта
заказа (домен `Order` проверяет `isOpenAt`/`isActive` при оформлении).

## 1. Эндпоинты

Файрвол `api` (JWT). Мутации — владелец (`WorkspaceAccess::getOwnedWorkspace`), чтение —
участник (`requireMember`).

| Метод | Роут | Экшен | Назначение |
|-------|------|-------|-----------|
| POST | `/api/v1/workspaces/{workspaceId}/venues` | `CreateVenueAction` | Создать точку |
| GET | `/api/v1/workspaces/{workspaceId}/venues` | `GetVenuesByWorkspaceAction` | Список точек воркспейса |
| GET | `/api/v1/venues/{venueId}` | `GetVenueAction` | Одна точка |
| PUT | `/api/v1/venues/{venueId}` | `UpdateVenueAction` | Полная замена основных данных |
| PUT | `/api/v1/venues/{venueId}/working-hours` | `SetVenueWorkingHoursAction` | Недельное расписание |
| POST | `/api/v1/venues/{venueId}/activation` | `ChangeVenueActivityAction` | Включить/выключить приём заказов |
| GET | `/api/v1/venues/{venueId}/logo` | `GetVenueLogoAction` | URL логотипа |
| POST | `/api/v1/venues/{venueId}/logo` | `UploadVenueLogoAction` | Загрузить логотип (multipart) |

## 2. Карта компонентов

```
Venue/
├─ Entity/Venue/
│  ├─ Venue           id, workspaceId, name, address, lat/lng?, phone?, supportsDelivery/Pickup,
│  │                  deliveryRadiusMeters?, workingHours, timezone, isActive
│  │                  buildNew / updateDetails / setWorkingHours / changeActivity / isOpenAt
│  ├─ WorkingHours    VO: недельное расписание (days[]); fromDays/closed/isOpenAt/toArray/fromArray
│  ├─ DaySchedule     VO: weekday + opensAt + closesAt (одна строка расписания)
│  └─ VenueRepositoryInterface
│
├─ Command/
│  ├─ CreateVenue            создать точку (владелец)
│  ├─ UpdateVenue            полная замена основных данных
│  ├─ SetVenueWorkingHours   заменить расписание
│  ├─ ChangeVenueActivity    вкл/выкл приём заказов
│  └─ UploadVenueLogo        загрузить логотип
│
├─ Query/
│  ├─ GetVenueById / GetVenuesByWorkspaceId → VenueView (общий read-model)
│  └─ GetVenueLogoByVenueId → URL логотипа
│
├─ Logo/VenueLogoStorageInterface   порт хранилища логотипа (findUrl / store)
└─ Service/WorkingHoursRule          валидация расписания
```

Порт `VenueRepositoryInterface` → `Infrastructure/Doctrine/Domain/Venue`. Миграция
`Version20260708140000`. `WorkingHours` хранится JSON-колонкой.

## 3. Часы работы и таймзона

- `WorkingHours` — недельное расписание из `DaySchedule` (weekday + `opensAt`/`closesAt`,
  строками `HH:MM`). Валидируется `WorkingHoursRule`. Дни без записи — закрыто; `closed()` —
  полностью закрытая точка.
- `Venue::isOpenAt(moment)` считает по **таймзоне точки** (`timezone`) — этим пользуется домен
  `Order`: `PlaceOrder` требует, чтобы точка была открыта (`requireVenueOpen: true`), а `quote`
  — нет (предпросмотр в любое время).
- Активность (`isActive`) — «мягкий стоп»: неактивная точка не принимает заказы независимо от
  расписания (`ChangeVenueActivity`).

## 4. Логотип

Хранение — по конвенции имени файла (без поля в БД): `public/upload/{slug}/venue-{venueId}.{ext}`
(slug — воркспейса), отдаётся веб-сервером по URL. Порт `VenueLogoStorageInterface`:

- `POST /venues/{id}/logo` (владелец, multipart поле `logo`, MIME image/jpeg|png по содержимому,
  ≤5 МБ, заменяет прежний);
- `GET /venues/{id}/logo` (любой авторизованный) → URL.

Адаптер — `Infrastructure/Storage/VenueLogoStorage` (параметры `upload.root_dir`/`upload.url_prefix`).

## 5. Режимы обслуживания и гео

- `supportsDelivery` / `supportsPickup` — какие типы заказов принимает точка (домен `Order`
  сверяет тип заказа с флагами).
- `deliveryRadiusMeters` — радиус доставки (простой радиус; полигоны отложены).
- `latitude` / `longitude` — гео точки (nullable, диапазоны не валидируются).

## 6. Ограничения / TODO

- Доставка задаётся радиусом; зоны-полигоны — на будущее.
- Часы работы — без спец-дней (праздники) и без внутридневных перерывов.
- Гео-координаты не валидируются по диапазонам.
- `PUT /venues/{id}` — полная замена основных данных (не частичный PATCH).
