# RB-08_EMERGENCY_HOTFIX

Экстренная раскатка security/hotfix релиза без стадии bake.

## Шаги

1. Проверить, что тег hotfix собран и доступен в `core_repo`.
2. Запустить:

```bash
ansible-playbook -i inventory/production/hosts.yml playbooks/hotfix.yml \
  -e "release_ref=<hotfix_tag>"
```

3. Проверить `healthz` на каждом production-хосте.
4. Проверить аудит раскаток (`/v1/deployments`, `kind=rollout`).
5. Зафиксировать инцидент и причину обхода canary в журнале изменений.

