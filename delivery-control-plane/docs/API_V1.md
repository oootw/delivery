# API_V1

Публичные эндпоинты control-plane:

- `POST /v1/register` — регистрация data-plane сервера.
- `GET /v1/license?server_token=...` — выдача лицензии для data-plane.
- `POST /v1/heartbeat` — heartbeat от data-plane.
- `POST /v1/release` — регистрация нового core релиза.
- `GET /v1/release/latest` — получение последнего core релиза.
- `POST /v1/deployments` — аудит rollout/hotfix/rollback.
- `GET /v1/servers` — инвентарь серверов для dynamic inventory.
- `POST /v1/auth/token` — выпуск JWT токена пользователю.

Форматы payload синхронизируются через `delivery-contracts`.

