# delivery-contracts

Общие контракты для `delivery-core` и `delivery-control-plane`.

## Состав

- Стабильные enum, используемые обоими сервисами.
- DTO публичных API control-plane.
- JSON Schema для проверок совместимости в CI.

## Версионирование

- Используем семантическое версионирование.
- Ломающее изменение контракта требует мажорной версии.
- Аддитивное изменение требует минорной версии.
- Патч-версия используется для неразрушающих исправлений и документации.

## Файлы контрактов

- `schemas/license.v1.json`
- `schemas/register.v1.json`
- `schemas/heartbeat.v1.json`
- `schemas/release.v1.json`

