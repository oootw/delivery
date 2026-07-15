# RB-06_ONBOARD_OWNER

Runbook онбординга нового владельца в контуре Фазы 7 (масштабирование + DevX).

## Шаги

1. Создать запись владельца в control-plane (slug + домен + оператор).
2. Подготовить overlay владельца локально в `delivery-core`:
   - `php bin/console app:custom:new <owner_slug>`
   - реализовать модуль в `custom/src/`
   - `php bin/console app:custom:doctor`
   - `php bin/console app:custom:check-compat`
3. Подготовить DNS-запись `owner.<root-domain>`.
4. Подготовить `host_vars/<owner>.yml`:
   - `owner_slug`;
   - `server_domain`;
   - `custom_repo`;
   - `pinned_ref` (опционально).
5. Запустить `playbooks/provision.yml -l <owner>`.
6. Проверить, что register-flow создал `OWNER_ID`, `WORKSPACE_ID`, `SERVER_TOKEN` в `shared/.env`.
7. Выполнить `playbooks/release.yml -l <owner> -e "release_ref=<tag>"`.
8. Проверить `https://<server_domain>/healthz`.
9. Убедиться, что heartbeat появился в control-plane (`/v1/servers`).

## Минимальные критерии готовности owner-overlay

- `app:custom:doctor` возвращает `exit_code=0`;
- `app:custom:check-compat` возвращает `OK: ядро ... совместимо ...`;
- в `manifest.json` указан актуальный `core_contract`;
- таблицы overlay имеют префиксы `custom_<module>_*`.

