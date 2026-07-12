# Домен Tarif — как работает

Небольшой домен-справочник тарифных планов и их лимитов. Namespace
`App\Application\Tarif\...`. Doctrine — `App\Infrastructure\Doctrine\Domain\Tarif`. Все пути
относительны `backend/`.

Тариф выбирается при старте подписки (домен `Subscription`), а его лимиты применяются при
создании воркспейсов (домен `Workspace`).

## 1. Эндпоинты

Отдельных HTTP-экшенов у домена нет — тарифы отдаются в составе других флоу и через
`GetAllTarifs` (используется списком планов). Записи (CRUD тарифов) — через админку.

## 2. Карта компонентов

```
Tarif/
├─ Entity/Tarif/
│  ├─ Tarif                 id, tarifCode, name, description, price (в копейках), features[]
│  ├─ TarifCodeEnum         basic | pro | enterprise
│  └─ TarifRepositoryInterface  (getByTarifCode / список)
│
├─ Query/
│  └─ GetAllTarifs → TarifDTO[]   список планов
│
└─ Service/
   └─ TarifLimits           политика лимитов по коду тарифа
      └─ maxWorkspaces(TarifCodeEnum): int
```

Порт `TarifRepositoryInterface` → `Infrastructure/Doctrine/Domain/Tarif`.

## 3. Лимиты (`Service/TarifLimits`)

`maxWorkspaces(tarifCode)` — сколько воркспейсов можно завести на данном плане. Сейчас **1 на
всех тарифах** и **зашито в коде**, а не в БД — потому что таблицы тарифов нет ни в одной
миграции (тарифы пока задаются в коде/сидах). Вызывается из `CreateWorkspace` (домен
`Workspace`): активная подписка → `TarifLimits->maxWorkspaces(subscription->tarifCode)` →
сравнение с `countByOwner`.

## 4. Ограничения / TODO

- Лимиты (`maxWorkspaces`, будущие `maxVenues`) — в коде, не в БД. Перенос в таблицу тарифа —
  отложенная задача (таблицы `tarif` ещё нет в миграциях).
- Цена (`price`) хранится в копейках; `GetAllTarifs` форматирует рубли на верхних слоях.
- Планы `basic/pro/enterprise` пока различаются только справочными полями, не лимитами.
