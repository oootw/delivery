# CUTOVER_PHASE6

Пошаговый cutover без big-bang для переноса `User/Subscription/Tarif` в control-plane.

## Этап 1. Подготовка

1. Развернуть control-plane (`control-plane-provision.yml`, затем `control-plane-deploy.yml`).
2. Применить миграции control-plane:

```bash
php bin/console doctrine:migrations:migrate --no-interaction
```

3. Настроить `LEGACY_DATABASE_URL` для one-shot импорта.

## Этап 2. Импорт данных

```bash
php bin/console app:cp:import-legacy
```

Проверка:
- таблица `cp_user` заполнена;
- таблица `cp_owner_subscription` заполнена;
- `GET /v1/license?server_token=...` возвращает тариф и статус.

## Этап 3. Переключение read-path

1. На data-plane задать `CONTROL_PLANE_URL` и `SERVER_TOKEN`.
2. Обновить кэш лицензии:

```bash
php bin/console app:license:refresh
```

3. Отправить heartbeat:

```bash
php bin/console app:fleet:heartbeat
```

4. Проверить `GET /v1/servers` на control-plane.

## Этап 4. Стабилизация

1. Запустить релиз через `release.yml` (canary -> bake -> production).
2. Проверить аудит `cp_deployment`.
3. Зафиксировать, что новые токены выдаются через `POST /v1/auth/token`.

## Этап 5. Деактивация legacy

После подтверждения стабильности:
1. отключить legacy выдачу лицензии в старом backend;
2. отключить legacy точки подписок/авторизации;
3. оставить fallback grace-период лицензии на data-plane.

