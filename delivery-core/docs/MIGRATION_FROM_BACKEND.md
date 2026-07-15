# MIGRATION_FROM_BACKEND

Этот документ фиксирует целевое состояние `delivery-core` после split.

## Что исключено из core

- `Subscription` домен;
- `Tarif` домен;
- `User/Authorize` домен;
- серверные API control-plane (`/v1/register`, `/v1/license`, `/v1/release`, `/v1/heartbeat`).

## Что осталось в core

- Data-plane API и домены workspace/заказы/кастомизация.
- Клиент лицензии control-plane + кэш.
- Heartbeat-клиент.
- Валидация JWT токенов, выпущенных control-plane.
- DevX-инструменты overlay: `app:custom:new`, `app:custom:doctor`, `app:custom:check-compat`.

## Переходный период

Пока legacy `backend/` сохраняется как совместимый слой. После полного cutover:
1. data-plane сборка читается только из `delivery-core`;
2. старые глобальные домены удаляются из legacy backend;
3. release-пайплайн использует только `delivery-core`.

## Golden path overlay

Рабочий путь owner-разработчика документирован отдельно:
- `docs/OWNER_OVERLAY_GOLDEN_PATH.md`.

