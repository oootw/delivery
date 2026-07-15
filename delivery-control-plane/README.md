# delivery-control-plane

Control-plane для парка data-plane серверов.

## Зона ответственности

- Регистрация серверов (`/v1/register`).
- Выдача лицензии (`/v1/license`).
- Приём heartbeat (`/v1/heartbeat`).
- Реестр релизов (`/v1/release`, `/v1/release/latest`).
- Аудит раскаток (`deployments`).

## Контракты

Сервис использует `delivery-contracts` как источник публичных DTO/enum/schema.

## Принципы

- Комментарии, ошибки и сообщения только на русском языке.
- Линейный код с guard-clause.
- Домен зависит от интерфейсов, а не от реализаций.

