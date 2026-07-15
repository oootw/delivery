# OWNER_OVERLAY_GOLDEN_PATH

Линейный путь для owner-разработчика: от пустого overlay до deploy-ready состояния.

## 1) Локальная инициализация

```bash
cd delivery-core
php bin/console app:custom:new acme
```

Команда создаёт каркас:
- `custom/manifest.json`;
- `custom/config/services.yaml`, `custom/config/routes.yaml`;
- базовые файлы в `custom/src/<Owner>/...`;
- `custom/migrations/.gitkeep`, `custom/tests/.gitkeep`.

Если `custom/` уже заполнен и нужен регенерат scaffold-файлов:

```bash
php bin/console app:custom:new acme --force
```

## 2) Разработка owner-модуля

1. Доработать файлы в `custom/src/`.
2. Поддерживать `manifest.json` как источник истины:
   - `owner` — slug владельца;
   - `core_contract` — semver-ограничение требуемого контракта ядра;
   - `modules` — список модулей overlay.
3. Для таблиц использовать только префикс `custom_<module>_*`.

## 3) Валидация до раскатки

```bash
php bin/console app:custom:doctor
php bin/console app:custom:check-compat
```

`app:custom:doctor` проверяет:
- корректность `custom/manifest.json`;
- согласованность модулей между manifest и кодом;
- дубли role/settings ключей;
- запрет на импорт `@internal` классов ядра;
- ограничения на имена таблиц (`custom_<module>_*`).

`app:custom:check-compat` блокирует rollout, если `core_contract` overlay не совместим с `core-contract.json` ядра.

## 4) Раскатка

После зелёных проверок:

1. Обновить overlay-репозиторий (`custom/`) в целевом owner-контуре.
2. Выполнить rollout через `delivery-infra/playbooks/release.yml` или точечный `custom-deploy.yml`.
3. Проверить `healthz` и heartbeat в control-plane.

## 5) Replace, events и upgrade-контракт

- **Replace:** внедрять через публичные порты ядра (`@api`) и DI-override, без правок внутренней логики ядра.
- **Events:** подписываться только на публичные доменные события и сообщения.
- **Upgrade под новый мажор контракта:** сначала обновить overlay и `core_contract`, затем раскатывать core.
