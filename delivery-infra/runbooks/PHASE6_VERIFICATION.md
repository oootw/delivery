# PHASE6_VERIFICATION

Проверки, которые нужно пройти перед финальным cutover и запуском потока Фазы 7.

## 1) Контракты

```bash
cd delivery-contracts
php tools/contract_check.php
```

Ожидаемый результат: `Контракты проверены: OK`.

## 2) Синтаксис PHP

```bash
cd /home/moont/dev/delivery
rg --files delivery-contracts delivery-core delivery-control-plane | rg '\.php$' | xargs -r -n 1 php -l
```

Ожидаемый результат: все файлы `No syntax errors detected`.

## 3) Inventory plugin

```bash
python3 -m py_compile delivery-infra/plugins/inventory/control_plane.py
```

Ожидаемый результат: команда завершается без ошибок.

## 4) Ansible syntax-check

```bash
cd delivery-infra
ansible-playbook --syntax-check playbooks/control-plane-provision.yml
ansible-playbook --syntax-check playbooks/control-plane-deploy.yml
ansible-playbook --syntax-check playbooks/provision.yml
ansible-playbook --syntax-check playbooks/release.yml
ansible-playbook --syntax-check playbooks/rollback.yml
ansible-playbook --syntax-check playbooks/hotfix.yml
ansible-playbook --syntax-check playbooks/drift-check.yml
```

Если `ansible-playbook` отсутствует в окружении, установить `ansible-core`
и повторить проверки на CI runner или локальной машине.

## 5) DevX-команды overlay (delivery-core)

```bash
cd /home/moont/dev/delivery/delivery-core
php bin/console app:custom:new acme --help
php bin/console app:custom:doctor
php bin/console app:custom:check-compat
```

Ожидаемый результат:
- команда `app:custom:new` доступна в help;
- `app:custom:doctor` возвращает стабильный `exit_code` (`0` или `2`);
- `app:custom:check-compat` отрабатывает без падения рантайма.

