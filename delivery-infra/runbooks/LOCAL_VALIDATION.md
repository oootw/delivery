# LOCAL_VALIDATION

Минимальный локальный прогон перед подключением боевого control-plane и dataplane.

## 1) Синтаксис playbooks

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
```

## 2) Lint

```bash
ansible-lint playbooks/*.yml roles/*/tasks/main.yml
```

## 3) Dry-run (без реального сервера)

```bash
ansible-playbook -i inventory/production playbooks/provision.yml --check \
  -e "ansible_become=false app_root=/tmp/delivery-app-local base_manage_packages=false app_clone_overlay=false provision_run_initial_deploy=false postgres_managed=true"

ansible-playbook -i inventory/production playbooks/release.yml --check \
  -e "ansible_become=false app_root=/tmp/delivery-app-local deploy_skip_healthcheck=true core_repo=https://github.com/git/git release_ref=master"
```

## 4) Что проверить руками

- В шаблонах нет секретов вне `vault.yml`.
- `app_root`, `keep_releases`, `healthcheck_path` корректно переопределяются через vars.
- register-flow в `roles/app/tasks/main.yml` не ломает локальный dry-run.
- playbook `release.yml` проходит ветку canary -> bake -> production.
- Для реального запуска флаги локального режима (`ansible_become=false`, `deploy_skip_healthcheck=true`) сняты.
