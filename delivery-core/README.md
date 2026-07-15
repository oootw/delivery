# delivery-core

Data-plane сервис для владельца (один сервер = один workspace).

## Включено

- Кэшируемый клиент лицензии control-plane.
- Команда принудительного обновления лицензии.
- Heartbeat в control-plane.
- Проверка JWT-токенов, выпущенных control-plane.
- Базовый `healthz`.
- DevX-команды overlay: `app:custom:new`, `app:custom:doctor`, `app:custom:check-compat`.

## Не включено

- Глобальные домены `Subscription`, `Tarif`, `User/Authorize`.
- Серверные API control-plane (`/register`, `/license`, `/release`, `/heartbeat` как источник истины).

## Overlay golden path

1. Создать каркас owner-overlay:
   - `php bin/console app:custom:new <owner_slug>`
2. Проверить структуру и guardrails:
   - `php bin/console app:custom:doctor`
3. Проверить контракт с ядром:
   - `php bin/console app:custom:check-compat`
4. После успешной проверки запускать rollout через `delivery-infra`.

Подробный поток и рекомендации для owner-разработчика: `docs/OWNER_OVERLAY_GOLDEN_PATH.md`.

