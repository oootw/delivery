# QUICK_FLOW

Короткая шпаргалка для Фазы 6: два контура (`controlplane` и `dataplane`) + canary/prod.

## 1) Подготовка

```bash
cd delivery-infra
ansible-galaxy collection install -r collections/requirements.yml
```

Проверить перед запуском:
- заполнен `inventory/production/group_vars/all/vault.yml`;
- в `inventory/production/hosts.yml` есть группы `controlplane`, `canary`, `production` (fallback);
- заполнены `host_vars/control-plane.yml` и `host_vars/test-owner.yml`.

`inventory/production` используется как единый источник: dynamic inventory plugin (`control_plane.yml`) + static fallback (`hosts.yml`).

## 2) Локальная проверка

```bash
ansible-playbook --syntax-check playbooks/control-plane-provision.yml
ansible-playbook --syntax-check playbooks/control-plane-deploy.yml
ansible-playbook --syntax-check playbooks/provision.yml
ansible-playbook --syntax-check playbooks/release.yml
ansible-playbook --syntax-check playbooks/rollout.yml
ansible-playbook --syntax-check playbooks/rollback.yml
ansible-playbook --syntax-check playbooks/hotfix.yml
ansible-playbook --syntax-check playbooks/drift-check.yml
ansible-playbook --syntax-check playbooks/custom-deploy.yml
ansible-lint playbooks/*.yml roles/*/tasks/main.yml
```

## 3) Первый реальный запуск

```bash
# 1. Подготовить control-plane
ansible-playbook -i inventory/production playbooks/control-plane-provision.yml -l control-plane

# 2. Подготовить data-plane
ansible-playbook -i inventory/production playbooks/provision.yml -l test-owner
```

На шаге data-plane provision сервер автоматически вызывает `POST /v1/register`
и получает `owner_id/workspace_id/server_token`, которые записываются в `shared/.env`.

## 4) Основные операции

```bash
# Раскатка через canary -> bake -> production
ansible-playbook -i inventory/production playbooks/release.yml \
  -e "release_ref=<tag_or_commit>"

# Только deploy control-plane
ansible-playbook -i inventory/production playbooks/control-plane-deploy.yml \
  -e "cp_release_ref=<tag_or_commit>"

# Экстренный hotfix в production (без bake)
ansible-playbook -i inventory/production playbooks/hotfix.yml \
  -e "release_ref=<tag_or_commit>"

# Ручной откат data-plane
ansible-playbook -i inventory/production playbooks/rollback.yml -l test-owner

# Проверка дрейфа версий
ansible-playbook -i inventory/production playbooks/drift-check.yml
```

Параметры rolling управляются в `inventory/production/group_vars/all/vars.yml`:
- `rollout_serial` — batch для production;
- `canary_serial` — batch для canary;
- `hotfix_serial` — batch для hotfix;
- `release_bake_seconds` — длительность bake между canary и production.

## 5) Быстрый чек после раскатки

- `curl -fsS https://<server_domain>/healthz` возвращает `200`;
- `current` указывает на новый release в `releases/`;
- в control-plane появилась запись heartbeat по серверу;
- в `cp_deployment` появилась запись аудита rollout/rollback.
