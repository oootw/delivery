# RB-09_CONTROL_PLANE_DOWN

Действия при недоступности control-plane.

## Симптомы

- ошибки `Не удалось получить лицензию из control-plane`;
- ошибки отправки heartbeat;
- рост возраста локального кэша лицензии.

## Шаги

1. Проверить доступность `GET /v1/license` и `POST /v1/heartbeat` на control-plane.
2. Проверить состояние БД control-plane и web-процесса.
3. Для data-plane:
   - убедиться, что `LICENSE_GRACE_TTL` не истёк;
   - временно не запускать rollout.
4. После восстановления control-plane:
   - выполнить `app:license:refresh` на data-plane;
   - выполнить `app:fleet:heartbeat`;
   - убедиться, что `drift` и `servers` синхронизированы.

