# INFRA_LINEAR_SCHEME

Линейная и схематичная документация Фазы 6 для `delivery-infra`.

## 1. Общая схема

```text
             [ inventory + vars + vault ]
                        |
                        v
      +---------------------------------------+
      | control-plane-provision.yml           |
      | roles: base -> postgres -> app        |
      +---------------------------------------+
                        |
                        v
      +---------------------------------------+
      | provision.yml (dataplane)             |
      | roles: base -> postgres -> app        |
      | + POST /v1/register                   |
      +---------------------------------------+
                        |
                        v
      +---------------------------------------+
      | release.yml                           |
      | canary -> bake -> production          |
      | role: deploy                          |
      +---------------------------------------+
                 |                      |
                 | успех                | ошибка healthcheck
                 v                      v
        [ новый current ]         [ rollback + audit ]
```

## 2. Линейный поток по шагам

1. Загрузить inventory из `inventory/production`:
   - `control_plane.yml` (dynamic inventory plugin);
   - `hosts.yml` (fallback, если API control-plane временно недоступен);
   - `group_vars/all/vars.yml`
   - `group_vars/all/vault.yml`
   - `host_vars/control-plane.yml`
   - `host_vars/test-owner.yml`
2. Выполнить `control-plane-provision.yml`.
3. Выполнить `provision.yml` для data-plane:
   - `base`: user/group/directories/systemd template;
   - `postgres`: локальный PostgreSQL или managed URL;
   - `app`: `shared/.env`, `shared/custom`;
   - регистрация в CP (`POST /v1/register`) и запись `owner_id/workspace_id/server_token` в `.env`.
4. Выполнить `release.yml`:
   - раскатка на `canary`;
   - выдержка `release_bake_seconds`;
   - раскатка на `production`;
   - создать новый release-каталог;
   - checkout ядра в `releases/<id>`;
   - проставить symlink на `shared/{custom,var,.env}`;
   - выполнить app-команды (в не-check режиме);
   - атомарно переключить `current`;
   - проверить `/healthz`;
   - записать аудит в `control-plane /v1/deployments`;
   - при ошибке вернуть прежний `current`.
5. При необходимости выполнить:
   - `rollback.yml` — ручной откат на предыдущий релиз;
   - `hotfix.yml` — экстренная раскатка без bake;
   - `drift-check.yml` — проверка расхождения версий;
   - `control-plane-deploy.yml` — независимый деплой control-plane;
   - `custom-deploy.yml` — обновить только overlay (`shared/custom`) без деплоя ядра.

## 3. Схема директорий на хосте

```text
/opt/app
├── releases/
│   ├── <release-A>/
│   │   ├── custom -> /opt/app/shared/custom
│   │   ├── var    -> /opt/app/shared/var
│   │   └── .env   -> /opt/app/shared/.env
│   └── <release-B>/
├── shared/
│   ├── custom/   (overlay repo owner)
│   ├── var/
│   └── .env
└── current -> /opt/app/releases/<active-release>
```

## 4. Что делает каждый playbook

- `playbooks/provision.yml`  
  Подготовка data-plane хоста с нуля + register-flow.

- `playbooks/control-plane-provision.yml`  
  Подготовка control-plane хоста с нуля.

- `playbooks/control-plane-deploy.yml`  
  Независимый деплой control-plane.

- `playbooks/rollout.yml`  
  Деплой на указанную группу data-plane с атомарным переключением.

- `playbooks/release.yml`  
  Релизный оркестратор canary -> bake -> production.

- `playbooks/rollback.yml`  
  Ручной откат симлинка `current` на предыдущий релиз + аудит.

- `playbooks/hotfix.yml`  
  Экстренный деплой на production без стадии bake.

- `playbooks/drift-check.yml`  
  Проверка дрейфа между `latest release` и отчетом серверов (`/v1/servers`).

- `playbooks/custom-deploy.yml`  
  Независимое обновление overlay-репозитория в `shared/custom`.

## 5. Режимы работы сейчас

- **Локальная валидация:**
  - `--syntax-check`
  - `ansible-lint`
  - `--check` с локальными override-переменными
- **Боевой запуск:**
  - без локальных override;
  - с реальными vault-секретами;
  - с включенным healthcheck;
  - с включенным аудитом раскаток в control-plane.

### Rolling knobs

- `rollout_serial` — batch раскатки production (`release.yml` и `rollout.yml`);
- `canary_serial` — batch раскатки canary в `release.yml`;
- `hotfix_serial` — batch для `hotfix.yml`;
- `release_bake_seconds` — пауза bake между canary и production.
