# delivery-infra

Линейная документация infra после Фазы 6 (split core/control-plane + hardening).

## 0) Что это

`delivery-infra` — Ansible-репозиторий для двух контуров:

- `controlplane`: API лицензий/регистрации/релизов;
- `dataplane`: owner-серверы (`canary` и `production`);
- один сервер = один owner/workspace;
- ядро и overlay деплоятся раздельно;
- раскатка ядра атомарная через `releases/` + symlink `current`.

Подробная схема потока: `docs/INFRA_LINEAR_SCHEME.md`.

## 1) Из чего состоит репозиторий

- `inventory/production/` — единый inventory-источник (dynamic plugin + static fallback `hosts.yml`).
- `inventory/production/group_vars/all/vars.yml` — общие параметры infra.
- `inventory/production/group_vars/all/vault.yml` — секреты (ansible-vault).
- `inventory/production/host_vars/control-plane.yml` — переменные control-plane.
- `inventory/production/host_vars/test-owner.yml` — owner-специфичные переменные.
- `roles/base|postgres|app|deploy` — роли.
- `playbooks/control-plane-*.yml|provision.yml|release.yml|rollout.yml|rollback.yml|hotfix.yml|custom-deploy.yml` — сценарии.

## 2) Линейный рабочий сценарий

1. **Подготовить секреты**  
   Заполнить `inventory/production/group_vars/all/vault.yml`, зашифровать через ansible-vault.
2. **Установить зависимости Ansible**  
   Поставить коллекции из `collections/requirements.yml`.
3. **Проверить синтаксис и lint**  
   Прогнать syntax-check и ansible-lint.
4. **Прогнать dry-run**  
   Проверить `provision` и `rollout` в режиме `--check`.
5. **Реальный запуск**
   Сначала `control-plane-provision`, затем `provision` data-plane.
6. **Релизный поток**
   `release.yml` выполняет canary -> bake -> production.

## 3) Быстрые команды

```bash
cd delivery-infra
ansible-galaxy collection install -r collections/requirements.yml
ansible-playbook --syntax-check playbooks/provision.yml
ansible-playbook --syntax-check playbooks/control-plane-provision.yml
ansible-playbook --syntax-check playbooks/control-plane-deploy.yml
ansible-playbook --syntax-check playbooks/release.yml
ansible-playbook --syntax-check playbooks/rollout.yml
ansible-playbook --syntax-check playbooks/rollback.yml
ansible-playbook --syntax-check playbooks/hotfix.yml
ansible-playbook --syntax-check playbooks/drift-check.yml
ansible-playbook --syntax-check playbooks/custom-deploy.yml
ansible-lint playbooks/*.yml roles/*/tasks/main.yml
```

Dry-run (локально, без реального сервера):

```bash
ansible-playbook -i inventory/production playbooks/provision.yml --check \
  -e "ansible_become=false app_root=/tmp/delivery-app-local base_manage_packages=false app_clone_overlay=false provision_run_initial_deploy=false postgres_managed=true"

ansible-playbook -i inventory/production playbooks/release.yml --check \
  -e "ansible_become=false app_root=/tmp/delivery-app-local deploy_skip_healthcheck=true core_repo=https://github.com/git/git release_ref=master"
```

## 4) Где смотреть пошаговые runbook

- `docs/QUICK_FLOW.md` — one-page шпаргалка по запуску и проверкам.
- `docs/INFRA_LINEAR_SCHEME.md` — как infra работает сейчас (схемы + линейный flow).
- `docs/ADR_PULL_MODEL_PHASE7.md` — решение по pull-модели (design-only, без включения в текущий prod-flow).
- `runbooks/LOCAL_VALIDATION.md` — локальная валидация перед реальным сервером.
- `tests/LOCAL_TEST_COMMANDS.md` — набор команд для копипаста.

## 5) GitVerse CI/CD (Фаза 6)

- `delivery-core/.gitverse-ci.yml`:
  - тесты core;
  - регистрация релиза в control-plane;
  - `playbooks/release.yml` (canary -> bake -> production).
- `delivery-control-plane/.gitverse-ci.yml`:
  - тесты control-plane;
  - `playbooks/control-plane-deploy.yml`.
- Обязательные секреты:
  - `CORE_DEPLOY_SSH_PRIVATE_KEY`;
  - `CP_DEPLOY_SSH_PRIVATE_KEY`;
  - `ANSIBLE_VAULT_PASSWORD`;
  - `CONTROL_PLANE_URL`.
