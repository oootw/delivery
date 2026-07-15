# LOCAL_TEST_COMMANDS

Команды для локальной проверки Фазы 6 (без боевого сервера).

```bash
cd delivery-infra
ansible-galaxy collection install -r collections/requirements.yml

# 1) Syntax check
ansible-playbook --syntax-check playbooks/control-plane-provision.yml
ansible-playbook --syntax-check playbooks/control-plane-deploy.yml
ansible-playbook --syntax-check playbooks/provision.yml
ansible-playbook --syntax-check playbooks/release.yml
ansible-playbook --syntax-check playbooks/rollout.yml
ansible-playbook --syntax-check playbooks/rollback.yml
ansible-playbook --syntax-check playbooks/hotfix.yml
ansible-playbook --syntax-check playbooks/drift-check.yml
ansible-playbook --syntax-check playbooks/custom-deploy.yml

# 2) Lint
ansible-lint playbooks/*.yml roles/*/tasks/main.yml

# 3) Dry-run: provision
ansible-playbook -i inventory/production/hosts.yml playbooks/provision.yml --check \
  -e "ansible_become=false app_root=/tmp/delivery-app-local base_manage_packages=false app_clone_overlay=false provision_run_initial_deploy=false postgres_managed=true"

# 4) Dry-run: rollout
ansible-playbook -i inventory/production/hosts.yml playbooks/release.yml --check \
  -e "ansible_become=false app_root=/tmp/delivery-app-local deploy_skip_healthcheck=true core_repo=https://github.com/git/git release_ref=master"
```
