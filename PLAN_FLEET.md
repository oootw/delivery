# PLAN_FLEET — переезд на «сервер на каждого владельца» (2026-07-15)

**Статус:** в работе. Фазы 0–5 выполнены; по Фазе 4 выполнен локальный минимум в
`delivery-infra` (без боевого сервера); по Фазе 6 собран базовый split-контур
(`delivery-contracts` + `delivery-core` + `delivery-control-plane`) и обновлён `delivery-infra`;
следующая основная — Фаза 7.
**Аудитория этого документа:** исполнитель со слабой моделью. Поэтому здесь **всё разжёвано**:
точные пути, точные команды, готовые к копированию сниппеты и критерии готовности (DoD) для
каждого шага. Не отступай от структуры путей — на них завязаны автозагрузка и деплой.

Этот план **заменяет архитектурную цель** прежней модели из `backend/PLAN_CUSTOMIZATION.md`
(Variant A: один мультитенантный деплой + `src/Custom/{slug}` + активация строкой в
`workspace_custom_module`). Мы переходим к **Variant C** (отдельный сервер на владельца), но
делаем его **поддерживаемым** за счёт автоматизации (Ansible + CI).

Важно: это **не означает**, что `backend` “запрещён” прямо сейчас. До полного cutover
(`delivery-core` как единственный data-plane рантайм) продуктовые изменения допустимо вести в
`backend`, если соответствующий домен ещё не перенесён и не стабилизирован в split-контуре.
Прежний код кастомизации не выбрасываем — переносим и упрощаем (см. §6 и Фазу 2).

---

## 0. Зафиксированные решения (не пересматривать без явного запроса владельца)

Владелец выбрал:

1. **Упаковка ядра — git-оверлей (два git-репозитория).**
   На сервере: `/opt/app` — рабочая копия репозитория **ядра** (обновляется `git`-ом на релиз
   master). Кастом владельца лежит **рядом**, в `custom/`, это **отдельный git-репозиторий
   владельца**; ядро его не трогает (папка в `.gitignore` ядра), а Symfony подхватывает код
   `custom/` в рантайме. **Никакого Docker-образа и никакого composer-пакета ядра.**
2. **Раскатка ядра — push через CI + Ansible.**
   После merge в `master`: CI прогоняет проверки, ставит тег релиза, затем запускает
   `ansible-playbook` против inventory всех серверов и раскатывает по SSH (rolling, health-check,
   автооткат при провале).
3. **Глобальные данные — центральный control-plane (mothership).**
   Отдельный сервис хранит подписки, тарифы, глобальную идентичность пользователей, реестр
   релизов ядра и инвентарь парка. Серверы владельцев (data-plane) ходят к нему по API за
   лицензией/тарифом и отчитываются о своей версии.
4. **Один сервер = один воркспейс** (полностью single-tenant).
   Это радикально упрощает кастом: slug перестаёт быть «селектором клиента», активация модуля =
   его наличие в overlay, а «Replace» стратегии ядра превращается из рантайм-резолвера в обычный
   DI-override (см. §6).

---

## 1. Глоссарий (чтобы не путаться)

| Термин | Значение |
|--------|----------|
| **Ядро (core)** | Общий код продукта. Один git-репозиторий `delivery-core`. Едет всем серверам одинаково. |
| **Кастом / overlay** | Код конкретного владельца. Отдельный git-репозиторий `delivery-custom-<owner>`. На сервере лежит в `custom/`. |
| **Data-plane** | Сервер (VM) владельца: ядро + его overlay + его БД. Обслуживает ровно один воркспейс. |
| **Control-plane (mothership)** | Центральный сервис: подписки, тарифы, юзеры, лицензии, реестр релизов, инвентарь серверов. Один на всё. |
| **Fleet (парк)** | Все data-plane серверы вместе. |
| **Release ref** | Git-тег/коммит ядра, который раскатан на серверах (напр. `v2.4.0` или коммит `abc123`). |
| **Contract version** | Версия публичного контракта ядра (портов/интерфейсов). Мажор ломает совместимость с overlay. |
| **Overlay manifest** | Файл `custom/manifest.json` — объявляет владельца, требуемую версию контракта ядра и список модулей. |
| **Capistrano-стиль** | Атомарный деплой через каталоги-релизы и symlink `current` (см. §4). |

---

## 2. Целевая архитектура (схема)

```
                          ┌──────────────────────────────────────────┐
                          │            CONTROL-PLANE (1 шт.)           │
                          │  delivery-control-plane                    │
                          │  • Пользователи (глобальная идентичность)  │
                          │  • Подписки / тарифы / биллинг             │
                          │  • Реестр релизов ядра (какой ref «latest»)│
                          │  • Инвентарь парка (какой сервер у кого)   │
                          │  API: /license, /register, /release        │
                          └──────────────▲──────────────▲─────────────┘
                                         │ HTTPS (лицензия/тариф, отчёт версии)
              ┌──────────────────────────┼──────────────┼────────────────────────┐
              │                          │              │                        │
     ┌────────┴─────────┐      ┌─────────┴────────┐   ┌─┴────────────────┐
     │  DATA-PLANE  A   │      │  DATA-PLANE  B   │   │  DATA-PLANE  C   │  ...
     │  VM владельца A  │      │  VM владельца B  │   │  VM владельца C  │
     │                  │      │                  │   │                  │
     │ /opt/app (ядро)  │      │ /opt/app (ядро)  │   │ /opt/app (ядро)  │
     │  └ custom/ (A)   │      │  └ custom/ (B)   │   │  └ custom/ (C)   │
     │ PostgreSQL (A)   │      │ PostgreSQL (B)   │   │ PostgreSQL (C)   │
     │ 1 воркспейс      │      │ 1 воркспейс      │   │ 1 воркспейс      │
     └──────────────────┘      └──────────────────┘   └──────────────────┘
              ▲                          ▲
              └───────── Ansible (push по SSH из CI на merge master) ─────────┘
```

**Три потока изменений (важно держать раздельными):**

- **Обновление ядра** → merge в `master` `delivery-core` → CI → Ansible раскатывает новый
  `release ref` на **все** серверы. Overlay каждого владельца **не трогается**.
- **Изменение кастома владельца** → push в `delivery-custom-<owner>` → отдельный деплой (Ansible
  `custom-deploy.yml`) **только на его сервер**. Ядро не трогается.
- **Новый сервер** → владелец (ты) вручную создаёт VM → запускаешь `provision.yml` → сервер
  регистрируется в control-plane и попадает в inventory.

---

## 3. Раскладка репозиториев (создаём 4 репозитория)

| Репозиторий | Что внутри | Кто меняет |
|-------------|-----------|-----------|
| **`delivery-core`** | Ядро: `src/` (Application/Http/Infrastructure/Shared/Console), `config/`, `migrations/` (только ядро), каркас кастомизации `src/Application/Customization/*`, `composer.json`, `bin/`, health-check, консольные команды совместимости. **Без клиентских модулей.** | ты (продукт) |
| **`delivery-custom-template`** | Шаблон overlay: пустой скелет `custom/` (см. §5.6) + пример модуля (перенесённый `Acme`) + `manifest.json` + свои тесты. Клонируется под каждого владельца в `delivery-custom-<owner>`. | ты → потом владелец |
| **`delivery-infra`** | Ansible: `inventory/`, `roles/`, `playbooks/`, `group_vars/`, `host_vars/`, `ansible-vault` секреты. | ты (ops) |
| **`delivery-control-plane`** | Mothership-сервис (§10). Стартовое наполнение — вынести из текущего монолита домены Subscription/Tarif/User. | ты (продукт) |

**Текущий репозиторий `delivery` (backend/frontend)** становится основой `delivery-core`
(backend) + источником для `delivery-control-plane` (вынос глобальных доменов). См. Фазу 6.

> Для слабой модели: сначала работаем **внутри текущего backend-репо**, готовя ядро к оверлею
> (Фазы 0–2), и только потом физически разносим по репозиториям (Фаза 6). Так меньше шансов
> сломать всё сразу.

### 3.1 Где разрабатывать функционал агрегатора сейчас (до финального cutover)

Ниже — практическая матрица “куда класть код”, чтобы не было путаницы.

| Область | Где **сейчас** делать изменения | Целевое место после полного cutover |
|---------|----------------------------------|--------------------------------------|
| Меню ресторанов (импорт/выгрузка), категории, позиции | `backend` (текущий data-plane код) | `delivery-core` |
| Точки/филиалы (`Venue`), доступность, клиентское меню | `backend` | `delivery-core` |
| Заказы, самовывоз, доставка, статус заказа | `backend` | `delivery-core` |
| Кастомизация owner (функционал + UI), overlay-модули | `backend/custom` + документация/процессы Фазы 7 | `delivery-core` + `delivery-custom-<owner>` |
| Глобальные подписки/тарифы/центральная идентичность | `delivery-control-plane` (по мере выноса) | `delivery-control-plane` |
| Раскатка/парк серверов/онбординг owner | `delivery-infra` | `delivery-infra` |
| Публичные DTO/enum/API-схемы между core и control-plane | `delivery-contracts` | `delivery-contracts` |

Операционное правило:
1. Если домен ещё живёт в `backend` и оттуда реально обслуживается продукт — пишем туда.
2. Если домен уже перенесён и используется в split-рантайме — пишем в соответствующий split-репозиторий.
3. Не дублируем одну и ту же фичу одновременно в двух местах без явного migration-задачи.

---

## 4. Раскладка на сервере (data-plane), Capistrano-стиль

Не делаем `git pull` поверх работающего кода (небезопасно на середине запроса). Вместо этого —
**атомарный деплой через каталоги-релизы и symlink**:

```
/opt/app/
├── releases/
│   ├── 20260715-abc1234/          ← чистый checkout ядра на release ref
│   │   ├── src/  config/  bin/  ...
│   │   ├── custom  ──symlink──►  /opt/app/shared/custom
│   │   ├── var     ──symlink──►  /opt/app/shared/var
│   │   └── .env    ──symlink──►  /opt/app/shared/.env
│   └── 20260714-def5678/          ← предыдущий релиз (для мгновенного отката)
├── shared/
│   ├── custom/                    ← git-репозиторий владельца (overlay). НЕ трогается ядром.
│   ├── var/                       ← логи, кэш, uploads (переживают релизы)
│   └── .env                       ← секреты окружения сервера
└── current  ──symlink──►  releases/20260715-abc1234
```

- **Обновление ядра** = новый каталог в `releases/`, `composer install`, проверки, миграции,
  затем **атомарная смена symlink `current`** + reload php-fpm. Старый релиз остаётся → **откат =
  вернуть symlink**.
- **`custom/` — общий (shared)**, симлинкается в каждый релиз. Значит обновление ядра его не
  затрагивает физически. Обновление кастома = `git pull` в `shared/custom` + reload (§8.4).
- Держим последние N=3 релиза, старые чистим.

Веб-сервер (nginx/Caddy) указывает document root на `/opt/app/current/public`.

---

## 5. Как ядро загружает кастом, не зная о нём (механика оверлея)

Это сердце плана. Ядро **никогда не импортирует** `App\Custom\*` (инвариант сохраняется, его
стережёт тест `CustomizationBoundaryTest`). Ядро лишь **объявляет точки, куда overlay может
подключиться**. Всё — через конфиги ядра с «мягким» (необязательным) подключением `custom/`.

### 5.1 Автозагрузка классов (composer PSR-4)

В `composer.json` **ядра**:

```json
{
  "autoload": {
    "psr-4": {
      "App\\": "src/",
      "App\\Custom\\": "custom/src/"
    }
  },
  "require": {
    "wikimedia/composer-merge-plugin": "^2.1"
  },
  "extra": {
    "merge-plugin": {
      "include": ["custom/composer.json"],
      "recurse": true,
      "replace": false,
      "ignore-duplicates": true,
      "merge-extra": false
    }
  }
}
```

- `App\Custom\` → `custom/src/`. Если `custom/` пуст — классов нет, ядро работает как есть.
- `composer-merge-plugin` **опционально** подмешивает `custom/composer.json` (доп. зависимости и
  автозагрузку overlay), если файл существует. Так overlay самодостаточен по зависимостям, а
  `composer install` на сервере ставит ядро **и** зависимости кастома.

### 5.2 DI-сервисы (Symfony)

В `config/services.yaml` **ядра** добавить в самый низ:

```yaml
imports:
    - { resource: '../custom/config/services.yaml', ignore_errors: not_found }
```

`ignore_errors: not_found` — если файла нет, Symfony молча пропускает (пустой сервер без кастома
валиден). В overlay — `custom/config/services.yaml`:

```yaml
services:
    _defaults:
        autowire: true
        autoconfigure: true
    App\Custom\:
        resource: '../src/'
        exclude: '../src/**/{Entity,Migrations,Tests}'
```

`autoconfigure: true` + существующие `_instanceof`-теги ядра (`app.custom_module`,
`app.settings_provider`, `app.custom_admin_menu`) навешиваются на классы overlay автоматически —
как и раньше. **Менять `_instanceof` в ядре не нужно**, они уже есть.

### 5.3 Роуты

В `config/routes.yaml` **ядра**:

```yaml
custom_routes:
    resource: '../custom/config/routes.yaml'
    ignore_errors: not_found
```

В overlay — `custom/config/routes.yaml`:

```yaml
custom_controllers:
    resource: '../src/'
    type: attribute
    prefix: /api/v1
```

(Пути в импортированном файле резолвятся относительно **него**: `../src/` от `custom/config/` =
`custom/src/`.)

### 5.4 Doctrine-маппинг сущностей overlay

В `config/packages/doctrine.yaml` **ядра**, блок `orm.mappings`, добавить:

```yaml
        Custom:
            type: attribute
            is_bundle: false
            dir: '%kernel.project_dir%/custom/src'
            prefix: 'App\Custom'
            alias: Custom
```

Каталог `custom/src` **должен существовать** (пусть даже пустой) — provision создаёт скелет
overlay (§5.6). Если сущностей нет, маппинг просто пуст.

### 5.5 Миграции overlay (отдельная история)

Миграции кастома **не смешиваем** с `migrations/` ядра (иначе конфликт при обновлении ядра). В
`config/packages/doctrine_migrations.yaml` **ядра**:

```yaml
doctrine_migrations:
    migrations_paths:
        'DoctrineMigrations': '%kernel.project_dir%/migrations'
        'Custom\Migrations': '%kernel.project_dir%/custom/migrations'
```

Одна команда `doctrine:migrations:migrate` применяет и ядро, и кастом (классы в разных
неймспейсах — не конфликтуют). Таблицы кастома по-прежнему именуй `custom_<module>_*`, чтобы
не пересечься с ядром. Каталог `custom/migrations` создаёт скелет overlay.

### 5.6 Скелет overlay (`custom/`) — что кладёт provision

```
custom/
├── manifest.json               ← владелец, требуемая версия контракта ядра, список модулей
├── composer.json               ← (опц.) зависимости overlay + PSR-4 (обычно пусто/дефолт)
├── config/
│   ├── services.yaml           ← §5.2
│   └── routes.yaml             ← §5.3
├── src/                        ← модули: App\Custom\<Module>\...
│   └── .gitkeep
├── migrations/                 ← Custom\Migrations\VersionYYYYMMDDHHMMSS
│   └── .gitkeep
└── tests/                      ← тесты overlay (свои, независимые от тестов ядра)
    └── .gitkeep
```

`custom/manifest.json`:

```json
{
  "owner": "acme",
  "core_contract": "^2.0",
  "modules": ["acme"],
  "notes": "человекочитаемое описание кастома владельца"
}
```

### 5.7 `.gitignore` ядра

В `.gitignore` **ядра** добавить:

```
/custom/
```

Так рабочая копия ядра игнорирует overlay-каталог, и `git pull`/checkout ядра его не удаляет и
не перезаписывает. На сервере `custom/` в каждом релизе — symlink на `shared/custom` (§4), а
`shared/custom` — самостоятельный git владельца.

---

## 6. Де-слугификация: что упрощаем vs текущий код

Из-за решения «**1 сервер = 1 воркспейс, 1 overlay**» многое из `PLAN_CUSTOMIZATION.md`
схлопывается. Ниже — что делаем с каждой частью.

| Было (Variant A) | Стало (Variant C) | Действие |
|------------------|-------------------|----------|
| `workspace_custom_module` (ws_id, slug) — выбор клиента среди многих | На сервере ровно один overlay → выбирать не из чего | **Удалить** таблицу/сущность/репо активации. Модуль «активен», если он присутствует в overlay. |
| `CustomModuleRegistry::activeFor(workspaceId)` | `activeModules()` — все обнаруженные модули активны | Упростить реестр: `activeFor` → `all()` (тег-итератор). Сохранить `slug()`/`previousSlugs()` только как **машинное имя** (префиксы таблиц, ключи настроек), не как селектор. |
| `TenantStrategyResolver.forWorkspace(): T` (Replace через рантайм-резолвер) | Один тенант → **DI-override**: overlay алиасит/декорирует сервис ядра | **Не строить** резолвер (Срез 4 отменяется). Replace = в `custom/config/services.yaml` алиас порта на кастом-реализацию (см. §6.1). |
| `WorkspaceContextListener` — slug из поддомена | Воркспейс фиксирован для сервера | Заменить: `WorkspaceContext` берёт воркспейс из `.env`/лицензии (§6.2), не из хоста. |
| `FeatureGate`: тариф из локального `Tarif` + гранты | Тариф/фичи из **лицензии control-plane** | Источник №1 (тариф) — лицензия от control-plane (кэш локально), плюс возможности активных модулей. Локальные гранты можно оставить. |
| `CustomRoleAssignment`, `custom-roles` эндпоинты | Остаются как есть | Роли по-прежнему нужны (staff внутри воркспейса). Владелец имеет все роли активных модулей. |
| Настройки (`WorkspaceSettings`, Configure) | Остаются | Работают как есть, ключ по `workspace_id` (единственному). |

### 6.1 Replace без резолвера (пример)

Ядро объявляет порт с дефолтной реализацией (обычная связка Symfony). Overlay переопределяет:

```yaml
# custom/config/services.yaml
services:
    # Подменяем расчёт цены заказа своей реализацией на этом сервере:
    App\Application\Order\Pricing\OrderPricingInterface:
        alias: App\Custom\Acme\Pricing\AcmePricing
```

Никаких `if (workspaceId === …)`, никакого рантайм-выбора: контейнер собирается один раз под
этот сервер. Инвариант «ядро не знает Custom» цел — ядро зависит только от `OrderPricingInterface`.

### 6.2 Фиксация воркспейса на сервере

- В `shared/.env` сервера: `WORKSPACE_ID=<число>` и `OWNER_ID=<число>` (выдаёт control-plane при
  регистрации сервера).
- `WorkspaceContext` заполняется из этого параметра (или из закэшированной лицензии), листенер по
  поддомену — удалить/упростить. Поддомен всё ещё может использоваться как публичный адрес
  (`owner.app`), но **не как источник идентичности** — источник авторитетен из конфигурации сервера.

---

## 7. Контракт совместимости и версионирование (чтобы обновление ядра не ломало кастом)

Это гарантия «мои апдейты не ломают клиентов». Механизм из трёх частей.

### 7.1 Версия контракта ядра

- Ядро объявляет **семвер контракта** — версию своих публичных портов/интерфейсов, на которые
  опирается overlay. Хранить в файле `core-contract.json` в корне ядра:
  ```json
  { "contract": "2.3.0" }
  ```
- Правило: **ломающее изменение существующего порта = мажор** (`2.x` → `3.0`). Аддитивное
  (новый метод с дефолтом, новый порт) = минор. Багофиксы = патч.
- Команда ядра `bin/console app:core:contract` печатает текущую версию (для CI и Ansible).

### 7.2 Требование overlay

- `custom/manifest.json` → `"core_contract": "^2.0"` (semver-констрейнт).
- Команда ядра `bin/console app:custom:check-compat` (ядро-owned, читает **файл** manifest, не
  классы Custom — инвариант цел):
  1. читает `core-contract.json` и `custom/manifest.json`;
  2. сверяет через `composer/semver` (уже в зависимостях транзитивно);
  3. **exit 0** если совместимо, **exit 1** с внятным сообщением иначе.

### 7.3 Гейт в раскатке

`rollout.yml` (§8) **перед** сменой symlink на каждом хосте выполняет `app:custom:check-compat`.
Если несовместимо → **этот хост пропускается** (старый релиз остаётся), факт пишется в отчёт.
Так один владелец со старым overlay против нового мажора ядра **не ломается молча** — он остаётся
на прошлой версии ядра до обновления своего overlay.

### 7.4 Правило миграций «expand/contract» (безопасность отката)

Миграции ядра пишем **обратно-совместимо** (сначала добавить колонку/таблицу, потом в следующем
релизе удалять старое). Тогда откат кода на прошлый релиз не упирается в несовместимую схему.
Прямой rollback миграций автоматикой **не делаем** (опасно) — откат = код на прошлый ref; схема
остаётся вперёд-совместимой.

---

## 8. Ansible (`delivery-infra`) — детально

### 8.1 Структура репозитория

```
delivery-infra/
├── ansible.cfg
├── inventory/
│   └── production/
│       ├── hosts.yml            ← список серверов парка
│       └── group_vars/
│           └── all/
│               ├── vars.yml     ← общие переменные (домены, версии php и т.п.)
│               └── vault.yml    ← секреты (ansible-vault), напр. приватные ключи деплоя
│       └── host_vars/
│           ├── owner-a.yml      ← owner_id, workspace_id, домен, custom-repo URL
│           └── owner-b.yml
├── roles/
│   ├── base/                    ← пакеты, пользователи, firewall, php-fpm, nginx
│   ├── postgres/                ← локальная БД владельца (или подключение к managed)
│   ├── app/                     ← первичная установка ядра+overlay (provision)
│   └── deploy/                  ← атомарный релиз ядра (rollout) + откат
└── playbooks/
    ├── provision.yml            ← первичная настройка нового сервера (ручной запуск)
    ├── rollout.yml              ← обновление ядра на всём парке (запускает CI)
    ├── custom-deploy.yml        ← деплой overlay одного владельца
    └── rollback.yml             ← откат ядра на предыдущий release ref
```

### 8.2 Inventory (пример)

`inventory/production/hosts.yml`:
```yaml
all:
  children:
    dataplane:
      hosts:
        owner-a:
          ansible_host: 203.0.113.10
        owner-b:
          ansible_host: 203.0.113.11
```

`host_vars/owner-a.yml`:
```yaml
owner_id: 1001
workspace_id: 5001
server_domain: acme.example.com
core_repo: git@github.com:oootw/delivery-core.git
custom_repo: git@github.com:oootw/delivery-custom-acme.git
```

`group_vars/all/vars.yml`:
```yaml
app_root: /opt/app
php_version: "8.4"
keep_releases: 3
control_plane_url: https://control.example.com
healthcheck_path: /healthz
```

### 8.3 `provision.yml` (ручной запуск после создания VM)

Делает **один раз** на новом сервере (ты создал VM руками):
1. `role: base` — apt-пакеты (php8.4-fpm+расширения, nginx, git, unzip, composer), системный
   пользователь `deploy`, firewall (22/80/443), настройка php-fpm/nginx (vhost на
   `/opt/app/current/public`).
2. `role: postgres` — поставить PostgreSQL 16 локально, создать БД/пользователя (пароль из vault),
   или (если managed) — только записать DSN в `shared/.env`.
3. `role: app` (первичная установка):
   - создать раскладку `/opt/app/{releases,shared}`, `shared/{var,custom}`, `shared/.env`;
   - `git clone` **overlay** владельца в `shared/custom` (по `custom_repo`);
   - собрать `shared/.env` из шаблона: `APP_ENV=prod`, `DATABASE_URL`, `WORKSPACE_ID`,
     `OWNER_ID`, `CONTROL_PLANE_URL`, ключи;
   - выполнить первый релиз (та же логика, что `deploy`, но на нужный `release ref`).
4. **Регистрация в control-plane**: `POST /register` (server_domain, owner_id) → получает/
   подтверждает `workspace_id`, серверный токен для API лицензий (кладём в `shared/.env`).

**DoD provision:** `curl https://<server_domain>/healthz` → `200 {"status":"ok"}`; сервер виден в
инвентаре control-plane; `bin/console doctrine:migrations:migrate` прошёл; overlay подхвачен
(`bin/console debug:container --tag=app.custom_module` показывает модуль владельца).

### 8.4 `deploy`-роль и `rollout.yml` (обновление ядра на весь парк)

Стратегия плейбука:
```yaml
- hosts: dataplane
  serial: 1            # по одному серверу (можно "25%")
  any_errors_fatal: false   # падение одного не блокирует остальных
  max_fail_percentage: 100
```

Шаги роли `deploy` на каждом хосте (идемпотентно):
1. Вычислить `release_dir = releases/<timestamp>-<short_sha>`.
2. `git clone --branch <release_ref> --depth 1` ядра в `release_dir` (или `git worktree`).
3. Симлинки: `release_dir/custom → shared/custom`, `release_dir/var → shared/var`,
   `release_dir/.env → shared/.env`.
4. `composer install --no-dev --optimize-autoloader --no-interaction` (подтянет и зависимости
   overlay через merge-plugin).
5. **Гейт совместимости:** `php release_dir/bin/console app:custom:check-compat`.
   Если exit≠0 → **прервать деплой этого хоста**, оставить `current` как есть, записать в отчёт,
   перейти к следующему хосту (не падать фатально).
6. `php release_dir/bin/console doctrine:migrations:migrate --no-interaction`
   (сначала ядро, затем кастом — один прогон, разные неймспейсы).
7. `php release_dir/bin/console cache:clear && cache:warmup`.
8. (Опц.) smoke-тесты overlay: `php release_dir/bin/console app:custom:doctor`.
9. **Атомарно** переключить `current → release_dir`; `systemctl reload php-fpm`.
10. **Health-check:** до N попыток `GET https://<server_domain>{{ healthcheck_path }}` → ждём 200.
11. **Если health-check провалился → автооткат:** вернуть `current` на предыдущий release_dir,
    reload php-fpm, пометить хост как failed в отчёте.
12. Почистить старые релизы (оставить `keep_releases`).

В конце плейбука — сводка: сколько хостов обновлено / пропущено по совместимости / откатилось.

### 8.5 `custom-deploy.yml` (деплой overlay одного владельца)

Запускается **на один хост** (`-l owner-a`), при push в его custom-репо:
1. `git -C shared/custom pull` (или checkout нужного ref).
2. `composer install` (если у overlay появились зависимости).
3. `doctrine:migrations:migrate` (применит новые `Custom\Migrations`).
4. `cache:clear` + `reload php-fpm`.
5. Health-check + откат `shared/custom` на прошлый commit при провале.

Обновление ядра и обновление кастома — **независимые** плейбуки. Это и есть требуемая развязка.

### 8.6 `rollback.yml`

`ansible-playbook rollback.yml -l owner-a` (или на всех): переключить `current` на предыдущий
`release_dir`, reload php-fpm, health-check. (Схема БД вперёд-совместима — см. §7.4.)

### 8.7 Секреты

- `ansible-vault` для `vault.yml` (пароль в CI как секрет `ANSIBLE_VAULT_PASSWORD`).
- Приватный SSH-ключ деплоя — секрет CI, добавляется в агент на время плейбука.
- В репозитории — **никаких** секретов в открытом виде.

---

## 9. CI/CD (в репозитории `delivery-core`)

### 9.1 `ci.yml` (на PR и push)

Джоба проверок (обнови текущий `.github/workflows/symfony.yml`, там сейчас PHP 8.0 и sqlite — а
проекту нужен **PHP 8.4** и Postgres):
1. setup-php **8.4**, `composer install`.
2. `php-cs-fixer --dry-run`, `phpstan` (если настроен).
3. `bin/console lint:container`.
4. `bin/console doctrine:schema:validate --skip-sync` (на поднятом Postgres-сервисе).
5. `bin/phpunit` — включая `tests/Unit/Architecture/CustomizationBoundaryTest` (ядро не
   импортирует `App\Custom`).
6. **Проверка контракта:** линтер/чек, что при изменении портов поднят `core-contract.json`
   (стартово — ручной чек-лист в PR-темплейте; позже автоматизировать diff по интерфейсам).

### 9.2 `release.yml` (на push в `master`, после зелёного `ci.yml`)

1. Определить новую версию (semver-тег или `vYYYY.MM.DD-<sha>`), создать git-тег → это `release ref`.
2. Обновить реестр релизов в control-plane: `POST /release {ref, contract}` (какой ref теперь
   «latest» для парка).
3. Запустить раскатку:
   ```
   ansible-playbook -i inventory/production/hosts.yml playbooks/rollout.yml \
     -e "release_ref=<tag>"
   ```
   Секреты (SSH-ключ, vault-пароль) — из GitHub Environments с **required reviewers** (ручное
   подтверждение перед раскаткой на прод — рекомендуется на старте).
4. Собрать и опубликовать сводку раскатки (обновлено/пропущено/откат) — в лог CI и уведомление.

> Инвентарь для CI берётся из `delivery-infra` (submodule или checkout второго репо шагом в
> workflow). SSH-доступ CI ко всем VM — по ключу деплоя. Это цена push-модели; при росте парка
> рассмотреть pull-модель (agent на VM), но сейчас — как решено, push.

### 9.3 Тесты overlay в CI владельца

В `delivery-custom-<owner>` — свой лёгкий CI: `composer install` (с ядром как dev-зависимостью
через path/VCS repo), прогон `custom/tests`, `app:custom:check-compat` против целевой версии
ядра. Так владелец узнаёт о несовместимости **до** раскатки.

---

## 10. Control-plane (`delivery-control-plane`) — минимальный контракт

Стартовое наполнение — **вынести из текущего монолита** домены `Subscription`, `Tarif`, `User`
(они и так «глобальные» по прежнему ADR). Плюс два новых домена: `Release` и `Server`.

**Данные:** `users`, `subscriptions`, `tarifs`, `servers (id, owner_id, domain, workspace_id,
core_ref, contract, last_seen)`, `core_releases (ref, contract, created_at, is_latest)`.

**API (минимум):**
- `POST /register` — сервер при provision регистрируется: `{domain, owner_id}` → `{workspace_id,
  server_token}`.
- `GET /license?server_token=…` — вернуть `{tarif, features[], status, valid_until}`. Data-plane
  **кэширует** ответ локально и работает в grace-period при недоступности control-plane (напр.
  72 ч), чтобы падение mothership не гасило парк.
- `POST /heartbeat` — сервер отчитывается `{core_ref, contract, health}` → обновляет `last_seen`.
- `GET /release/latest` — текущий `release ref` + `contract` (для pull-варианта в будущем).
- `POST /release` — CI регистрирует новый релиз.

**Как это меняет ядро (data-plane):**
- `FeatureGate` источник №1 (тариф) читает **закэшированную лицензию** от control-plane, а не
  локальную таблицу `Tarif`.
- Регистрация пользователей/оплаты подписки — на control-plane (не на сервере владельца).

**Деплой control-plane:** обычный одиночный сервис (свой Ansible-плейбук или тот же паттерн),
не входит в fleet-раскатку ядра. Это отдельный контур.

> Прагматично: на **Фазе 5** можно ограничиться «тонкой» лицензионной прослойкой (эндпоинт
> `/license` поверх существующих таблиц монолита) и отложить полный вынос доменов и регистрацию/
> heartbeat. Полный control-plane — Фаза 6+.

---

## 11. Безопасность и секреты (чек-лист)

- Секреты сервера — только в `shared/.env` (права `600`, владелец `deploy`), не в git.
- Ansible-секреты — `ansible-vault`; пароль/ключи — в GitHub Secrets/Environments.
- `server_token` для `/license` — уникальный на сервер, ротация поддерживается control-plane.
- CI → серверы: отдельный SSH-ключ деплоя, ограниченный (только `deploy`-пользователь,
  `command=`-обёртка при желании).
- HTTPS обязателен (Caddy авто-TLS или nginx+certbot) на всех доменах.
- `/healthz` — публичный, **без утечки** внутренних деталей (только `status`, версия по желанию).

---

## 12. Пошаговый план внедрения (фазы с DoD)

Порядок важен: сначала делаем ядро «оверлей-совместимым» внутри текущего репо, потом инфру, потом
физически разносим репозитории и поднимаем control-plane. Каждая фаза заканчивается **зелёными
проверками** и не ломает предыдущие.

### Фаза 0 — Health-check и версия контракта (ядро)
**Статус:** выполнено.
**Цель:** дать раскатке за что «зацепиться».
Шаги:
1. Эндпоинт `GET /healthz` (публичный, вне JWT-файрвола) → `200 {"status":"ok","ref":"<git sha>"}`.
   Файл `src/Http/Action/System/HealthzAction.php`, роут без префикса `/api/v1`, добавить в
   `security.yaml` в публичные пути.
2. Файл `core-contract.json` в корне ядра + команда `app:core:contract`
   (`src/Console/Command/CoreContractCommand.php`).
**DoD:** `curl localhost/healthz` → 200; `bin/console app:core:contract` печатает версию; тесты зелёные.

### Фаза 1 — Механика оверлея (конфиги ядра)
**Статус:** выполнено.
**Цель:** ядро умеет подхватывать `custom/`, но работает и без него.
Шаги (строго по §5): `composer.json` (PSR-4 `App\Custom\`→`custom/src/`, merge-plugin);
`services.yaml` (import ignore_errors); `routes.yaml` (custom_routes ignore_errors);
`doctrine.yaml` (маппинг Custom); `doctrine_migrations.yaml` (путь `custom/migrations`);
`.gitignore` (`/custom/`). Создать локально пустой скелет `custom/` (§5.6) для проверки.
**DoD:** без `custom/` — `lint:container` OK, `schema:validate` OK, тесты зелёные. С пустым
скелетом `custom/` — то же самое (ничего не сломалось, но пути подхватываются).

### Фаза 2 — Де-слугификация ядра
**Статус:** выполнено.
**Цель:** убрать slug-селектор и рантайм-резолвер (§6).
Шаги:
1. Упростить `CustomModuleRegistry`: `activeFor(workspaceId)`/`isActive` → `all()`
   (все обнаруженные модули активны). Обновить вызовы.
2. Удалить домен активации `WorkspaceCustomModule` (+ Doctrine-зеркало, репо, миграция —
   миграцию **не удалять из истории**, а завести новую, дропающую таблицу).
3. Отменить Срез 4 (`TenantStrategyResolver`) — его не строим. Replace документируем как
   DI-override (§6.1).
4. Заменить `WorkspaceContextListener` (поддомен) на фиксацию воркспейса из `.env`/лицензии (§6.2).
5. `CustomAccess`: убрать зависимость активности от таблицы, оставить проверку ролей.
6. Обновить `CustomizationBoundaryTest` и юнит-тесты реестра под новое поведение.
**DoD:** тесты зелёные; в ядре нет чтения `workspace_custom_module`; `debug:container
--tag=app.custom_module` работает; воркспейс берётся из конфигурации.

### Фаза 3 — Overlay-шаблон (`delivery-custom-template`) + перенос Acme
**Статус:** выполнено.
**Цель:** эталонный overlay, из которого клонируются владельцы.
Шаги:
1. Создать скелет `custom/` (§5.6) как отдельный репозиторий-шаблон.
2. Перенести `src/Custom/Acme/*` → `custom/src/Acme/*` (неймспейс `App\Custom\Acme` не меняется).
   Перенести миграцию Acme → `custom/migrations` (неймспейс `Custom\Migrations`).
3. Заполнить `manifest.json` (owner=acme, core_contract из текущей версии ядра).
4. Свои тесты overlay в `custom/tests`.
5. Удалить `src/Custom/` из ядра (после переноса) — ядро больше не возит клиентский код.
**DoD:** на локальном ядре с симлинком `custom/`→клон шаблона: роуты Acme
(`debug:router | grep acme`) на месте; сущность видна (`schema:validate`); `app:custom:check-compat`
= OK; тесты overlay зелёные.

### Фаза 4 — Ansible (`delivery-infra`): provision + rollout на 1 тестовом сервере
**Статус:** выполнен локальный минимум (без фактического боевого хоста).
**Цель:** поднять один реальный сервер и обновлять его автоматикой.
Шаги (по §8): собрать роли `base/postgres/app/deploy`, `inventory/production` с одним хостом,
`provision.yml`, `rollout.yml`, `rollback.yml`, `custom-deploy.yml`, vault.
**DoD:** `ansible-playbook provision.yml -l test-owner` поднимает сервер с нуля до `200 /healthz`;
`rollout.yml -e release_ref=<tag>` обновляет ядро атомарно с health-check; ручной `rollback.yml`
возвращает прошлый релиз; `custom-deploy.yml` обновляет overlay независимо от ядра.

**Текущий результат (2026-07-15):**
- Собран `delivery-infra` с рабочими ролями и playbooks.
- Добавлены vault-шаблоны и линейная документация по текущему потоку infra.
- Пройдены локальные проверки: `--syntax-check`, `ansible-lint`, dry-run `--check`.
- Открытый хвост Фазы 4: отдельный проход на реальном тестовом сервере (факт `200 /healthz`).

### Фаза 5 — CI/CD раскатки + тонкая лицензия
**Статус:** выполнен базовый контур (GitVerse pipeline + тонкая лицензия + переключение FeatureGate).
**Цель:** merge в master → авто-раскатка; тариф из лицензии.
Шаги:
1. Обновить `ci.yml` (PHP 8.4, Postgres, boundary-тест, контракт-чек).
2. `release.yml`: тег → регистрация релиза → `ansible-playbook rollout.yml` (Environments +
   ручное подтверждение).
3. «Тонкая» лицензия: эндпоинт `/license` (пока поверх существующих таблиц монолита) + чтение
   `FeatureGate` источником №1 из закэшированной лицензии.
**DoD:** тестовый merge в master прогоняет CI и раскатывает ядро на тестовый сервер; отчёт
раскатки виден; несовместимый overlay корректно **пропускается** (гейт §7.3), а не ломается.

**Текущий результат (2026-07-15):**
- Добавлен GitVerse pipeline `/.gitverse-ci.yml` с CI-стадией (PHP 8.4 + Postgres) и manual release-стадией rollout.
- Добавлен endpoint лицензии `GET /v1/license` с валидацией `server_token` и контрактом `tarif/features/status/valid_until`.
- Реализован data-plane провайдер и кэш лицензии (`app:license:refresh`, TTL + grace).
- `FeatureGate` переключён на лицензии как источник №1; модули и grants сохранены как источники №2 и №3.
- В `delivery-infra` rollout обновлён: несовместимый overlay не валит раскатку, а корректно пропускает хост.

### Фаза 6 — Физическое разнесение репозиториев + control-plane
**Статус:** выполнен базовый контур split + control-plane (без боевого cutover).
**Цель:** полноценные `delivery-core` / `delivery-control-plane`.
Шаги: выделить `delivery-core` из текущего backend; вынести домены `Subscription/Tarif/User` в
`delivery-control-plane`; реализовать `/register`, `/license`, `/heartbeat`, `/release`, реестр
релизов и инвентарь; перевести data-plane на регистрацию/heartbeat/грейс-период.
**DoD:** новый сервер регистрируется в control-plane; парк отчитывается версиями; тариф/фичи
приходят из control-plane; ядро и control-plane деплоятся независимо.

**Текущий результат (2026-07-15):**
- Добавлены каркасы репозиториев `delivery-contracts`, `delivery-core`, `delivery-control-plane`.
- Вынесены общие контракты (enum + DTO + JSON schema) и подключены compatibility-check скрипты.
- В `delivery-control-plane` собраны API `/v1/register`, `/v1/license`, `/v1/heartbeat`,
  `/v1/release`, `/v1/release/latest`, `/v1/deployments`, `/v1/servers`, `/v1/auth/token`.
- В `delivery-core` оставлены data-plane части: лицензия-клиент+кэш, heartbeat-клиент, healthz,
  валидация JWT (без локальной выдачи токенов).
- В `delivery-infra` добавлены двухконтурные playbook'и (`controlplane/dataplane`), release-поток
  `canary -> bake -> production`, аудит раскаток и dynamic inventory plugin с fallback.

### Фаза 7 — Масштабирование парка и DevX
**Статус:** выполнен базовый контур DevX + rolling/pull-документация.
Шаги: скаффолдер overlay (`app:custom:new`), `app:custom:doctor` (валидатор overlay),
документация для владельца-разработчика, `serial`/rolling-настройки под размер парка,
рассмотреть pull-модель обновления при росте числа серверов.
**DoD:** новый владелец разворачивается по инструкции за понятные шаги; overlay-ошибки ловятся
`doctor` до раскатки.

**Текущий результат (2026-07-15):**
- В `delivery-core` добавлены `app:custom:new`, `app:custom:doctor`, `app:custom:check-compat` + `core-contract.json`.
- Обновлены owner-доки: `delivery-core/docs/OWNER_OVERLAY_GOLDEN_PATH.md`, `RB-06_ONBOARD_OWNER`, `PHASE6_VERIFICATION`.
- В `delivery-infra` параметризованы rolling-batch (`rollout_serial`, `canary_serial`, `hotfix_serial`) и bake-window.
- Release-поток и документация переведены на единый inventory-источник `inventory/production` (dynamic + static fallback).
- Зафиксирован ADR по pull-модели как следующий срез без включения в текущий боевой контур.

---

## 13. Миграция с текущего состояния (чек-лист переноса)

- [x] `src/Custom/Acme/*` → overlay-шаблон `custom/src/Acme/*` (Фаза 3).
- [x] Миграция Acme → `custom/migrations` (неймспейс `Custom\Migrations`).
- [x] Удалить `workspace_custom_module` (сущность/зеркало/репо) + миграция-дроп (Фаза 2).
- [x] Не строить `TenantStrategyResolver` (Срез 4 отменён) — Replace через DI-override.
- [x] `WorkspaceContextListener` (поддомен) → фиксация воркспейса из `.env`/лицензии.
- [x] `FeatureGate`: тариф из лицензии control-plane (Фаза 5), не из локального `Tarif`.
- [x] `.github/workflows`: PHP 8.0+sqlite → PHP 8.4+Postgres; добавить boundary/контракт-чеки.
- [x] Обновить `backend/PLAN_CUSTOMIZATION.md` и `CUSTOMIZATION_GUIDE.md`: пометить Variant A
      как замороженный, сослаться на этот план.

---

## 14. Инварианты и анти-паттерны (нарушать нельзя)

**Инварианты:**
- Ядро (`App\Application|Infrastructure|Http|Console`) **никогда** не импортирует `App\Custom\*`
  и не содержит имён клиентов. Стережёт `CustomizationBoundaryTest`.
- Overlay зависит от портов/`Shared` ядра, **не наоборот**.
- Обновление ядра **никогда** не пишет в `custom/` (симлинк на shared, `.gitignore`).
- Ломающее изменение порта → **мажор контракта** + держим старый порт до миграции overlay.
- Миграции ядра **вперёд-совместимы** (expand/contract) — чтобы откат кода не бился о схему.

**Анти-паттерны:**
- `git pull` поверх работающего кода вместо атомарного релиза-symlink.
- Смешивать миграции ядра и кастома в одном каталоге/неймспейсе.
- Класть секреты в git (ядро/overlay/infra).
- Ломать порт ядра «под одного клиента» без нового мажора контракта.
- Молча раскатывать несовместимый мажор на старый overlay (гейт §7.3 обязателен).
- Складывать клиентскую логику в таблицы ядра (только `custom_<module>_*`).
- Возвращать slug как **селектор** (машинное имя — можно, выбор клиента — нет: 1 сервер = 1 overlay).

---

## 15. Открытые вопросы / решения по умолчанию

| Вопрос | Значение по умолчанию (если не уточнишь) |
|--------|------------------------------------------|
| Веб-сервер на VM | Caddy (авто-TLS) — минимум ручной возни; альтернатива nginx+certbot. |
| БД на VM | Локальный PostgreSQL 16 через `role: postgres`; managed — опционально через DSN. |
| Ручное подтверждение раскатки | **Да** на старте (GitHub Environment reviewers), позже можно снять. |
| Grace-period лицензии оффлайн | 72 часа кэша. |
| Кол-во хранимых релизов | 3. |
| `serial` раскатки | 1 (по одному) на старте; при росте — `25%`. |
| Pull-модель обновления | Отложена; сейчас push (как решено). Пересмотреть при >~20 серверах. |
| Мульти-воркспейс на сервере | Нет (1 сервер = 1 воркспейс, как решено). |

---

## 16. Приложения (готовые сниппеты)

### 16.1 `/healthz` (упрощённо)
```php
// src/Http/Action/System/HealthzAction.php
#[Route('/healthz', name: 'healthz', methods: ['GET'])]
public function __invoke(): JsonResponse
{
    return new JsonResponse(['status' => 'ok', 'ref' => $this->coreRef]); // coreRef из env/файла VERSION
}
```
`security.yaml`: путь `^/healthz` — `PUBLIC_ACCESS` (вне файрвола `api`).

### 16.2 nginx vhost (document root на current)
```
server {
    listen 443 ssl;
    server_name acme.example.com;
    root /opt/app/current/public;
    location / { try_files $uri /index.php$is_args$args; }
    location ~ ^/index\.php(/|$) {
        fastcgi_pass unix:/run/php/php8.4-fpm.sock;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT $realpath_root;
        internal;
    }
    location ~ \.php$ { return 404; }
}
```

### 16.3 Ключевой фрагмент `deploy`-роли (атомарная смена + откат)
```yaml
- name: Symlink new release
  file: { src: "{{ release_dir }}", dest: "{{ app_root }}/current", state: link, force: yes }
- name: Reload php-fpm
  systemd: { name: "php{{ php_version }}-fpm", state: reloaded }
- name: Health check
  uri: { url: "https://{{ server_domain }}{{ healthcheck_path }}", status_code: 200 }
  register: health
  retries: 5
  delay: 3
  until: health.status == 200
  ignore_errors: yes
- name: Rollback on failure
  file: { src: "{{ previous_release_dir }}", dest: "{{ app_root }}/current", state: link, force: yes }
  when: health is failed
```

### 16.4 `app:custom:check-compat` (псевдологика)
```
$core = json_decode(file_get_contents('core-contract.json'))->contract;   // "2.3.0"
$req  = json_decode(file_get_contents('custom/manifest.json'))->core_contract; // "^2.0"
if (!Semver::satisfies($core, $req)) { fwrite(STDERR, "overlay требует $req, ядро $core"); exit(1); }
exit(0);
```

---

---

# ЧАСТЬ II. АУДИТ И ЗАКРЫТИЕ ПРОБЕЛОВ (2026-07-15)

Часть I описывала «счастливый путь». Ниже — аудит под **долгую поддержку**: то, что первая версия
плана не покрывала, но без чего парк серверов не живёт годами. Каждый пункт заканчивается
строкой **Решение** (это и есть то, что реализуем — не «подумать», а «сделать так»).

Аудит основан на реальном коде проекта. Факты, которые меняют картину:
- Приложение использует **фоновые воркеры** (Symfony Messenger, транспорт `async`): письма, SMS,
  уведомления, импорт меню из POS идут в фоне. Значит на **каждом** сервере крутятся воркеры.
- Есть **5 планировщик-команд** (`src/Console`): `ExpireLoyaltyPointsCommand`,
  `ExpireAbandonedOrdersCommand`, `RecalculateWaitTimesCommand`, `CancelStalePastDueSubscriptionsCommand`,
  `GrantAdminCommand`. Часть из них — **data-plane**, часть — **control-plane** (см. §17.A).
- Есть **Mercure** (realtime hub) — на каждом сервере свой.
- Есть **фронтенд** (Expo / React Native + react-native-web), потребляющий API. Он в план не входил.
- Куча **секретов per-owner**: `APP_SECRET`, `JWT_SECRET`, `MERCURE_JWT_SECRET`, БД, а также
  **платёжные/SMS ключи владельца** (`CLOUDPAYMENTS_*`, `YOOKASSA_*`, `SMS_API_*`, `IIKO_*`,
  `APP_POS_SECRET_KEY`). Это отдельный контур управления конфигурацией.

---

## §17. Пробелы и решения (по темам)

### §17.A — Фоновые процессы на сервере (воркеры, крон, Mercure)

**Пробел:** план деплоил только web (php-fpm через symlink), но игнорировал воркеры Messenger,
крон-команды и Mercure. При атомарной смене релиза воркеры продолжают крутить **старый** код,
крон может дёрнуть команду из старого релиза, а Mercure вообще не разворачивался.

**Решения:**

1. **Messenger-воркеры — systemd-юниты, а не `&`-процессы.** Шаблон
   `app-messenger@.service` (инстансы `app-messenger@1`, `@2`), `ExecStart=/opt/app/current/bin/console
   messenger:consume async --time-limit=3600 --memory-limit=192M`, `Restart=always`. Ключевое:
   `WorkingDirectory=/opt/app/current` через symlink.
2. **Грациозный рестарт воркеров при деплое.** В `deploy`-роли **после** смены symlink:
   `bin/console messenger:stop-workers` (воркеры доработают текущее сообщение и завершатся, systemd
   поднимет их уже на новом релизе). Так нет потери сообщений и нет старого кода в фоне.
3. **`failed`-транспорт мониторим.** Крон/алерт на `messenger:failed:show` (растущая очередь
   провалов = инцидент). Ретраи уже настроены (max_retries=3).
4. **Крон — через systemd-таймеры** (надёжнее crontab, есть логи в journald). Каждая команда — свой
   `.timer` + `.service`, вызывающий `/opt/app/current/bin/console <cmd>`. **Разделение по контуру:**

   | Команда | Контур | Почему |
   |---------|--------|--------|
   | `ExpireLoyaltyPointsCommand` | **data-plane** | бонусы воркспейса |
   | `ExpireAbandonedOrdersCommand` | **data-plane** | заказы воркспейса |
   | `RecalculateWaitTimesCommand` | **data-plane** | время ожидания воркспейса |
   | `CancelStalePastDueSubscriptionsCommand` | **control-plane** | подписки глобальны (§10) |
   | `GrantAdminCommand` | ручная утилита | не по расписанию |

   Это ещё один аргумент за вынос подписок в control-plane (§10): их крон **не должен** дублироваться
   на каждом сервере владельца.
5. **Один воркер не должен запуститься дважды на смене релиза.** systemd + `messenger:stop-workers`
   это гарантирует (нет ручного управления PID).
6. **Mercure — в provision.** Разворачивать hub на каждой VM (бинарь Caddy+Mercure или контейнер),
   генерировать `MERCURE_JWT_SECRET` уникально на сервер, прописывать `MERCURE_URL`/`MERCURE_PUBLIC_URL`
   в `shared/.env`. Роль `role: mercure` (или часть `base`).
7. **opcache/realpath cache при смене symlink.** php-fpm держит realpath-кэш → после симлинка старый
   путь может «залипнуть». В `deploy`: после `systemctl reload php-fpm` дополнительно сбрасывать
   opcache (`cachetool opcache:reset` или endpoint), либо использовать `opcache.revalidate_freq=0` +
   reload. Зафиксировать в роли, иначе будут «призрачные» старые страницы после деплоя.

### §17.B — Резервные копии, восстановление, DR

**Пробел:** у каждого владельца **своя БД и свои uploads**, а бэкапов в плане не было вообще. Для
«поддерживать годами» это критично №1.

**Решения:**

1. **Бэкап БД на каждом сервере:** ежедневный `pg_dump` + **WAL-архивирование** (PITR) через
   `pgBackRest` (рекомендую) или минимум `pg_dump` по крону. RPO ≤ 24 ч (лучше ≤ 15 мин с WAL),
   RTO — восстановление за понятное время.
2. **Оффсайт-хранилище.** Бэкапы уезжают в объектное хранилище (S3-совместимое), **вне** VM владельца
   (иначе смерть VM = потеря бэкапа). Отдельный bucket/prefix на владельца, шифрование на стороне
   клиента.
3. **Что бэкапим:** (а) БД; (б) `shared/var/uploads` (или `APP_SHARE_DIR`) — пользовательские файлы;
   (в) `shared/.env` — **секреты** (шифрованно). `custom/` не бэкапим отдельно — он в git владельца
   (но фиксируем текущий commit в отчёте бэкапа, чтобы знать пару «данные ↔ версия overlay»).
4. **Ретенция:** 7 дней ежедневных + 4 недельных + 6 месячных (настраиваемо). Юридический минимум
   хранения после оффбординга — см. §17.J.
5. **Учебные восстановления (restore drills).** Раз в квартал — реально восстановить один сервер из
   бэкапа на тестовую VM и прогнать `/healthz`+smoke. Бэкап без проверенного restore = не бэкап.
6. **Control-plane бэкапится отдельно** и с бóльшим приоритетом (потеря = потеря биллинга/подписок
   всего парка).
7. **Роль `role: backup`** в provision ставит агент бэкапа + расписание + креды оффсайта (из vault).

### §17.C — Наблюдаемость: логи, метрики, алерты

**Пробел:** был только `/healthz` и `/heartbeat`. Для парка нужен централизованный обзор, иначе
«узнаёшь о падении от клиента».

**Решения:**

1. **Централизованные логи.** Каждый сервер шлёт логи (Symfony monolog + systemd/journald + nginx) в
   центральный сборщик (**Grafana Loki + promtail** — легковесно; альтернатива — ELK). Тег `owner`/
   `server` в каждой строке. Хранить N дней.
2. **Метрики.** `node_exporter` (CPU/RAM/**диск** — переполнение диска убивает Postgres и логи),
   `postgres_exporter`, php-fpm/nginx метрики → **Prometheus** на control-plane-контуре → **Grafana**
   дашборд по всему парку.
3. **Трекинг ошибок.** Sentry-совместимый (self-hosted GlitchTip или Sentry) — на каждый сервер, тег
   `owner` + `release ref`. Так исключение видно с привязкой к владельцу и версии ядра.
4. **Алерты (обязательный минимум):** сервер недоступен (`/healthz` не 200 / нет `heartbeat` N минут);
   диск > 85%; растёт `messenger:failed`; ошибок 5xx всплеск; истекает TLS-сертификат; провал ночного
   бэкапа; недоступность control-plane из data-plane.
5. **Fleet-дашборд.** Из `heartbeat` (§10) — таблица «сервер → owner → core_ref → contract → last_seen
   → health». Сразу видно, кто отстал по версии (drift, §17.F).
6. **Уровни health-check (важно):** `/healthz` = **liveness** (процесс жив, отвечает). Добавить
   `/readyz` = **readiness** (БД доступна, миграции применены, лицензия валидна/в грейсе). Rollout
   ждёт **readyz**, а не liveness.

### §17.D — Что такое «контракт ядра» (публичный API) и его эволюция

**Пробел:** «порты» упоминались, но не было чёткой границы «что overlay имеет право использовать и на
что я, как автор ядра, обязан не ломать совместимость». Без этого через год любой рефакторинг ядра —
русская рулетка для клиентов.

**Решения:**

1. **Явно объявленная поверхность API ядра** (всё остальное — `@internal`, меняется свободно):
   - интерфейсы-порты в `App\Shared\Contract\*` и `App\Application\{Domain}\...Interface`;
   - **доменные события**, на которые overlay вправе подписаться (`App\Application\**\Events\*`);
   - **классы сообщений** Messenger, которые overlay вправе слать/обрабатывать;
   - **имена консольных команд** и **HTTP API `/api/v1`** (внешний контракт);
   - каркас кастомизации: `CustomModuleInterface`, `SettingsProviderInterface`,
     `CustomAdminMenuContributorInterface`, `FeatureGateInterface`, `CustomRole`, `CustomAccess`.
2. **Аннотации `@api` / `@internal`** на классах/методах. Всё публичное помечено `@api`; отсутствие
   метки = internal. В CONTRIBUTING ядра — правило: «менять `@api` только по deprecation-циклу».
3. **Каталог точек расширения** — отдельный документ ядра `CORE_EXTENSION_POINTS.md`, версионируемый
   вместе с `core-contract.json` (см. §17.E).
4. **Deprecation-цикл (жёсткое правило).** Ломать `@api` нельзя сразу: `deprecate` (пометка +
   `trigger_deprecation()` + запись в CHANGELOG) → живёт **минимум 2 минорных релиза** → удаляется в
   ближайшем **мажоре** контракта. Мажор контракта = гейт совместимости (§7.3) не пускает старые
   overlay, пока их не обновят. Так «мои обновления не ломают клиентов» становится **процессом**, а не
   надеждой.
5. **Контракт-тест-кит.** Ядро публикует набор тестов/`app:custom:doctor`-проверок, которыми overlay
   в своём CI убеждается, что он корректно реализует/потребляет порты **до** раскатки (§9.3).
6. **События и сообщения версионируем как API.** Изменение payload доменного события/сообщения =
   изменение контракта (минор — только аддитивно; ломающее — мажор + deprecation).

### §17.E — Каталог точек расширения overlay (что можно / что нельзя)

**Пробел:** не было явного списка «разрешённых швов». Это лучший инструмент долгой поддержки —
исполнитель и владелец-разработчик видят рамки.

**Решение — зафиксировать в `CORE_EXTENSION_POINTS.md`:**

**Разрешено overlay:**
- добавлять HTTP-эндпоинты (`custom/config/routes.yaml` → `/api/v1`);
- добавлять свои сущности/таблицы **только** `custom_<module>_*`;
- подписываться на **публичные** доменные события ядра;
- регистрировать обработчики/отправку публичных сообщений Messenger;
- **подменять порт ядра** через DI-alias/decorator (Replace, §6.1);
- добавлять настройки (`SettingsProviderInterface`), роли (`roles()`), разделы админки
  (`CustomAdminMenuContributorInterface`), возможности (`capabilities()`);
- переопределять шаблоны Twig **только** через выделенный namespace `@Custom/...` (ядро объявляет
  путь `custom/templates/` с namespace `Custom`; переопределение core-шаблонов «в лоб» — запрещено,
  иначе обновление ядра ломает вёрстку).

**Запрещено overlay (проверяется, см. ниже):**
- импортировать `@internal` ядра;
- миграции, изменяющие **не-custom** таблицы ядра;
- менять firewall/security ядра, `config/packages/*` ядра;
- переопределять версии зависимостей ядра в `custom/composer.json` (merge-plugin: `replace:false`,
  конфликт версий = ошибка сборки);
- держать клиентскую бизнес-логику в таблицах ядра.

**Guardrails (автоматика):**
- `CustomizationBoundaryTest` (ядро ⇏ Custom) — уже есть, сохранить.
- Новый тест/линтер: overlay-миграции трогают только `custom_*` (парсинг SQL/имён таблиц).
- `app:custom:doctor`: дубли ключей настроек/ролей, конфликт таблиц, `@internal`-импорты overlay,
  несоответствие `manifest.json` (несуществующие модули).

### §17.F — Раскатка: canary/staging, пиннинг версии, hotfix, дрейф

**Пробел:** был `serial:1`, но не было (а) обкатки релиза до парка, (б) возможности владельцу
остаться на старой версии, (в) быстрого security-фикса, (г) обнаружения «отставших» серверов.

**Решения:**

1. **Canary/staging.** Отдельная группа inventory `canary` (1–2 сервера: твой тестовый + доброволец).
   `release.yml` катит **сначала на `canary`**, ждёт «выдержки» (bake time, напр. 30–60 мин или ручное
   подтверждение), и только потом — на группу `production`. Ловит регрессии до массовой раскатки.
2. **Пиннинг версии на владельца.** `host_vars: pinned_ref: v2.3.0` (или поле в control-plane).
   `rollout.yml` уважает пин: закреплённый сервер **не** обновляется на latest. Нужно, когда владелец
   не готов/идёт кастом-миграция. Пин — временный, с TTL/напоминанием (иначе накопятся зомби-версии).
3. **Emergency hotfix.** Отдельный workflow `hotfix.yml` (`workflow_dispatch`, ref + причина) —
   быстрый путь мимо canary-выдержки для security. Логируется в аудит (§17.L).
4. **Обнаружение дрейфа + реконсиляция.** `heartbeat` шлёт фактический `core_ref`/`contract`.
   Control-plane сравнивает с целевым (latest/pin) и **флагует отставших**. Крон-реконсиляция может
   до-раскатить или хотя бы алертить. Так «раскатилось не на всех» становится **видимым**.
5. **Источник истины инвентаря — один.** Канонический список серверов — таблица `servers` в
   **control-plane**. Ansible использует **динамический inventory** (плагин, дергающий control-plane
   API), а не руками поддерживаемый `hosts.yml`. Устраняет расхождение «git-inventory ↔ реальный парк».
   (На Фазе 4 можно начать со статического `hosts.yml`, но заложить переход на динамический к Фазе 6.)

### §17.G — Миграции БД на масштабе (безопасность данных)

**Пробел:** правило expand/contract было, но без деталей для парка.

**Решения:**

1. **Только неблокирующие миграции.** Никаких операций с долгой блокировкой на живой таблице
   (напр. `ALTER TABLE ... ADD COLUMN` с дефолтом на старом PG, перестройка индексов без `CONCURRENTLY`).
   Правило в CONTRIBUTING + ревью.
2. **Схема и бэкофилл — раздельно.** Тяжёлый перенос данных — **не** в миграции (она блокирует
   деплой всего сервера), а отдельной идемпотентной командой/через Messenger, запускаемой после
   деплоя. Миграция только меняет схему аддитивно.
3. **Транзакционность DDL.** Postgres выполняет DDL транзакционно per-version → упавшая миграция не
   оставляет полу-состояния. При `serial:1` один упавший сервер не рушит остальных (§8.4 шаг 5/11).
4. **Порядок «ядро → кастом».** Один прогон `migrate` применяет оба неймспейса; если кастом-миграция
   зависит от новой core-таблицы — это ок (core-версии в том же прогоне идут первыми по времени).
   Зафиксировать: **overlay-миграции не должны опережать** соответствующий релиз ядра (гейт контракта
   косвенно это держит).
5. **Деструктив — только через relase-лаг.** Удаление колонки/таблицы — минимум на релиз позже, чем
   код перестал её читать (contract-фаза). Иначе откод кода упрётся в отсутствующую колонку.
6. **Пер-сервер бэкап перед миграцией.** `deploy` снимает быстрый `pg_dump` (или checkpoint/снапшот)
   **до** `migrate` — дешёвая страховка на конкретной раскатке.

### §17.H — Безопасность и радиус поражения

**Пробел:** push-модель даёт CI SSH-доступ ко **всему** парку — компрометация CI = компрометация всех
владельцев. Плюс не был описан контур доверия data-plane ↔ control-plane и жизненный цикл секретов.

**Решения:**

1. **Изоляция ключа раскатки.** Отдельный SSH-ключ **только** для деплоя, пользователь `deploy` без
   sudo сверх нужного (точечные `sudo`-правила на `systemctl reload`, `migrate`). Ключ — в защищённом
   GitHub Environment с required reviewers и ограничением по ветке `master`. Рассмотреть **bastion**
   (CI → bastion → парк), чтобы не раздавать прямой доступ. Явно записать: это осознанный риск push-
   модели; при росте парка (>~20) — переезд на pull (agent на VM тянет подписанный релиз).
2. **Подписанные релизы.** `release.yml` подписывает тег/артефакт; сервер при деплое проверяет
   подпись (git tag signature) — защита от подмены ref.
3. **Доверие data-plane ↔ control-plane.** Уникальный `server_token` на сервер (ротация из control-
   plane) + control-plane API **версионируется** (`/v1/license`) и **обратно-совместим** (старые
   серверы не должны падать при апдейте control-plane). mTLS — опция для усиления.
4. **Секреты уникальны на сервер и генерятся в provision.** `APP_SECRET`, `JWT_SECRET`,
   `MERCURE_JWT_SECRET` — генерируются при провижене (не переиспользуются между владельцами),
   `shared/.env` права `600`, владелец `deploy`. Ротация — процедура в runbook (§20).
5. **Изоляция владельцев — сильная (плюс модели).** Отдельная VM + БД на владельца → overlay-код и
   утечка не задевают других. Это выигрыш Variant C; зафиксировать как преимущество.
6. **Enforcement лицензии.** Ответ `/license` содержит `status` (`active|past_due|suspended|expired`)
   и `valid_until`. Поведение data-plane: `active` — норма; `past_due` — работа + баннер; `suspended/
   expired` (после грейса 72 ч) — **read-only режим** (приём заказов заблокирован, данные доступны на
   чтение/экспорт). Никогда не «удаляем данные при неоплате».

### §17.I — Фронтенд в парке (пропущен полностью)

**Пробел:** фронтенд (Expo RN + react-native-web) не рассматривался. У каждого владельца свой
API-домен → фронтенд должен знать, куда ходить, и, возможно, кастомизироваться.

**Решения:**

1. **Web-сборка на владельца.** CI фронтенда собирает web-бандл с `API_BASE=https://<owner_domain>`
   (из конфигурации владельца) и раздаётся с того же сервера (nginx, отдельный `location`) или из
   CDN. Провижен раскладывает бандл рядом с бэкендом.
2. **Кастомизация фронта — сначала конфигом, потом кодом.** Тема/лого/фичефлаги владельца приходят из
   `/api/v1/.../settings` и `/license` (features) → **одна** кодовая база фронта, разное отображение.
   Кодовый форк фронта на владельца (overlay фронта) — только если конфигом не решается; выносим в
   отдельную фазу и отдельный overlay-репо фронта (симметрично бэкенду). **По умолчанию — конфиг.**
3. **Мобильные сборки (App Store/Google Play).** Открытый вопрос: одно white-label приложение с
   выбором сервера vs сборка на владельца. **Дефолт:** одно приложение, домен владельца
   вводится/зашивается через deep-link/конфиг; per-owner нативные сборки — позже, по запросу.
   Зафиксировать в §15.

### §17.J — Жизненный цикл владельца: онбординг и оффбординг

**Пробел:** был provision, но не было управляемого создания и **удаления** владельца.

**Решения:**

1. **Идентичность владельца.** Стабильный машинный `owner` (kebab, напр. `acme`) — для имени репо
   `delivery-custom-acme`, префиксов, доменов; плюс числовой `owner_id` из control-plane. Оба
   иммутабельны.
2. **Онбординг (runbook, §20):** завести владельца/подписку в control-plane → создать VM (руками) →
   создать DNS-запись `owner.<root>` → `provision.yml` → `POST /register` → сид начальных данных
   (создать воркспейс, админа) → smoke `/readyz` → передать доступы.
3. **Оффбординг (runbook):** остановить биллинг → финальный бэкап + **экспорт данных владельцу**
   (машиночитаемо) → снять DNS → `deregister` в control-plane → снести VM → хранить финальный бэкап
   юридический срок → по истечении — безвозвратно удалить (право на забвение).
4. **DNS/TLS автоматизация.** На старте — `owner.<root-domain>` с авто-TLS (Caddy/ACME).
   Собственные домены владельцев (`shop.acme.com`) — через направление CNAME + ACME; описать в runbook.

### §17.K — Dev-опыт (для долгой поддержки — критично)

**Пробел:** не описано, как разрабатывать ядро с примером overlay и как владельцу-разработчику
работать локально против ядра.

**Решения:**

1. **Локальный запуск ядра + пример overlay.** `compose.yaml` для dev поднимает Postgres/Mercure/
   mailer; `custom/` симлинкается на `delivery-custom-template` (пример Acme). `make dev` — один вход.
2. **Локальный запуск overlay владельца против ядра.** Ядро подключается как dev-зависимость (VCS/path
   repo) на **пиннутой** версии контракта; локальная БД + сид. Владелец видит свой код в полном
   приложении.
3. **`app:custom:new <owner>`** (скаффолдер overlay по шаблону) и **`app:custom:doctor`** (валидатор,
   §17.E) — обязательный DevX-инструментарий.
4. **Golden-path документация:** «как завести модуль», «как подменить порт», «как подписаться на
   событие», «как обновить overlay под новый мажор ядра» — с рабочими примерами.

### §17.L — Аудит-лог изменений и системные апгрейды

**Решения:**

1. **Аудит раскаток.** Каждая раскатка/hotfix/rollback пишет запись «кто, когда, какой ref, на какие
   серверы, результат» — в control-plane (`deployments`) и в лог CI. Нужен для разбора инцидентов
   спустя месяцы.
2. **Системные апгрейды (PHP/ОС).** Роль `base` управляет версией PHP и пакетами; апгрейд PHP/ОС —
   **сначала на canary**, затем парк, отдельным плейбуком с бэкапом. Кадэнс — фиксируем (напр.
   раз в квартал + внеплановые security).
3. **Идемпотентность провижена.** Повторный `provision.yml` не должен затирать данные/секреты: все
   «создающие» шаги — с `creates:`/проверкой существования (БД, `.env`, ключи не пересоздаются).

---

## §18. Матрица конфигурации per-owner (где что живёт)

Чтобы не путать «секрет / настройку / фичу» — единая таблица источников. Правило: **секреты — в
`.env` (деплой), изменяемые настройки — в БД (без деплоя), доступ к фичам — из лицензии**.

| Параметр | Где живёт | Меняется без деплоя? | Кто владелец данных |
|----------|-----------|----------------------|---------------------|
| `APP_SECRET`, `JWT_SECRET`, `MERCURE_JWT_SECRET` | `shared/.env` (генерится в provision) | нет | сервер |
| `DATABASE_*` | `shared/.env` | нет | сервер |
| Платёжные ключи владельца (`CLOUDPAYMENTS_*`, `YOOKASSA_*`) | `shared/.env` **или** зашифрованные `WorkspaceSettings` | зависит | владелец |
| `SMS_API_*`, `IIKO_*`, `APP_POS_SECRET_KEY` | `shared/.env` / зашифр. настройки | зависит | владелец |
| `WORKSPACE_ID`, `OWNER_ID`, `CONTROL_PLANE_URL`, `server_token` | `shared/.env` (из control-plane) | нет | control-plane |
| Бренд/тема/бизнес-настройки | `WorkspaceSettings` (БД) | **да** | владелец |
| Тариф и доступ к фичам | лицензия control-plane (кэш) | да (на стороне CP) | control-plane |
| Целевой `core_ref` / `pinned_ref` | control-plane `servers` (+ host_vars на старте) | да | ты (ops) |

> Платёжные ключи — компромисс: как секреты логичнее в `.env` (не в общей БД), но владельцу удобнее
> менять их из админки. **Дефолт:** хранить в БД **в зашифрованном виде** (ключ шифрования — в `.env`),
> чтобы владелец менял без деплоя, а дамп БД не раскрывал ключи.

---

## §19. Ops-воркстрим: дополнительные фазы дорожной карты

Фазы 0–7 (Часть I) — «фичевый» путь. Параллельно ведём **Ops-воркстрим** (эти фазы можно делать
вперемешку, но перед первым **боевым** владельцем обязательны O1–O3):

- **O1 — Воркеры/крон/Mercure/opcache (§17.A).** systemd-юниты Messenger + `messenger:stop-workers`
  в deploy; systemd-таймеры крон-команд (с разделением data/control-plane); Mercure в provision;
  сброс opcache при смене symlink. **DoD:** после деплоя воркеры на новом релизе, сообщения не
  теряются, крон логируется в journald, Mercure отвечает, старые страницы не «залипают».
- **O2 — Бэкапы и DR (§17.B).** Роль `backup`, ежедневный дамп + WAL/PITR, оффсайт, ретенция,
  первый **restore drill**. **DoD:** восстановление тестовой VM из бэкапа проходит `/readyz`.
- **O3 — Наблюдаемость (§17.C).** Централизованные логи, метрики (вкл. диск), Sentry, алерты,
  `/readyz`, fleet-дашборд. **DoD:** остановка тестового сервера → приходит алерт; дашборд видит дрейф.
- **O4 — Canary + пиннинг + дрейф (§17.F).** Группа `canary`, bake-time в `release.yml`, `pinned_ref`,
  реконсиляция дрейфа, динамический inventory из control-plane. **DoD:** релиз идёт canary→prod;
  пиннутый сервер пропускается; отставший сервер флагуется.
- **O5 — Безопасность контура (§17.H).** Изоляция deploy-ключа/bastion, подпись релизов, версионир.
  control-plane API, генерация уникальных секретов, режим read-only по лицензии. **DoD:** просрочка
  лицензии → read-only после грейса; апдейт control-plane не роняет старые серверы.
- **O6 — Контракт и точки расширения (§17.D/E).** `CORE_EXTENSION_POINTS.md`, аннотации `@api/@internal`,
  deprecation-политика, контракт-тест-кит, guardrail на custom-миграции и Twig-namespace. **DoD:**
  overlay с `@internal`-импортом или чужой миграцией — красный CI; deprecation виден в CHANGELOG.
- **O7 — Фронтенд в парке (§17.I).** Per-owner web-сборка с API_BASE, конфиг-темизация из settings/
  license. **DoD:** бандл владельца ходит на его домен; тема применяется без пересборки.
- **O8 — Онбординг/оффбординг/DNS (§17.J) + runbooks (§20) + аудит (§17.L).** **DoD:** новый владелец
  разворачивается по runbook; оффбординг экспортирует данные и чисто сносит; раскатки пишутся в аудит.

**Порядок здравого смысла:** Фазы 0–5 (ядро/инфра/CI) → **O1–O3 обязательно** → первый боевой
владелец → O4–O8 по мере роста парка. Фаза 6 (control-plane) синхронизируется с O4/O5 (динамический
inventory, версионир. API, лицензия).

---

## §20. Runbooks (эксплуатационные сценарии — писать в `delivery-infra/runbooks/`)

Короткие пошаговые инструкции «что делать, когда». Обязательный набор для долгой поддержки:

- **RB-01 Сервер недоступен** — проверить `/healthz`→`/readyz`, journald, диск, Postgres, php-fpm;
  типовые причины (диск 100%, упал воркер, БД не поднялась).
- **RB-02 Провал миграции при раскатке** — как читать отчёт rollout, ручной откод symlink, фикс-вперёд.
- **RB-03 Откат релиза** — `rollback.yml -l <owner>`; когда откат безопасен (схема вперёд-совместима).
- **RB-04 Восстановление из бэкапа** — выбрать точку, восстановить БД+uploads, свериться с версией
  overlay из отчёта бэкапа, `/readyz`.
- **RB-05 Ротация секрета** (`APP_SECRET`/`JWT`/`server_token`/платёжные) — последствия (инвалидируются
  токены/сессии), порядок, окно.
- **RB-06 Онбординг владельца** (§17.J) и **RB-07 Оффбординг владельца** (§17.J).
- **RB-08 Emergency hotfix** — `hotfix.yml`, обход canary, запись в аудит.
- **RB-09 Control-plane недоступен** — поведение data-plane (грейс лицензии), приоритет восстановления.
- **RB-10 Владелец обновляет overlay под новый мажор ядра** — снять пин, прогнать контракт-кит,
  раскатать custom, снять со старого ref.
- **RB-11 Апгрейд PHP/ОС по парку** — canary→prod, бэкап, проверки.

---

## §21. Обновлённые решения по умолчанию (дополняет §15)

| Вопрос | Решение по умолчанию |
|--------|----------------------|
| Воркеры Messenger | systemd-юниты + `messenger:stop-workers` при деплое |
| Крон | systemd-таймеры; подписочные крон — на control-plane, не на data-plane |
| Бэкапы | pgBackRest (PITR) + оффсайт S3-совместимый, ретенция 7/4/6, квартальный restore-drill |
| Логи/метрики/ошибки | Loki+promtail, Prometheus+node/pg_exporter+Grafana, Sentry-совместимый |
| Health | `/healthz` (liveness) + `/readyz` (readiness, ждёт rollout) |
| Публичный API ядра | `@api`/`@internal` + `CORE_EXTENSION_POINTS.md` + deprecation ≥2 минора до мажора |
| Раскатка | canary → bake-time → production; уважать `pinned_ref` |
| Инвентарь | канонично в control-plane, Ansible dynamic inventory (со статики на Фазе 4) |
| Тема/бренд фронта | конфиг из settings/license (одна кодовая база); код-форк фронта — позже |
| Мобильное приложение | одно white-label с конфигом домена; per-owner нативные сборки — по запросу |
| Платёжные/интеграционные ключи | в БД зашифрованно (ключ шифрования в `.env`) — меняются без деплоя |
| Лицензия expired/suspended | read-only после грейса 72 ч; данные не удаляем |
| Радиус поражения push-раскатки | изолированный deploy-ключ + bastion + подпись релизов; pull при >~20 серверах |
| Аудит раскаток | таблица `deployments` в control-plane + лог CI |

---

---

# ЧАСТЬ III. ВТОРОЙ ПРОХОД АУДИТА (2026-07-15)

Ещё один проход по остаточным пробелам — то, что всплывает именно на дистанции в годы и именно для
**этого** продукта (доставка/HoReCa, РФ, платежи CloudPayments/ЮKassa, POS iiko/rkeeper, мобильный
фронт на Expo). Формат прежний: **Решение** — это и есть что делаем.

## §22. Остаточные пробелы и решения

### §22.A — Версионирование HTTP API и рассинхрон «фронт ↔ бэкенд»
**Пробел:** ядро и фронтенд деплоятся независимо; при раскатке ядра у владельца в браузере/на
телефоне уже загружен **старый** фронт. Плюс `/api/v1` — внешний контракт, но политика его эволюции
не задана.
**Решения:**
1. `/api/v1` — **стабильный контракт**. Ломающее изменение = **новый префикс `/api/v2`**, старый
   держим до миграции клиентов (симметрично контракту ядра, §17.D). Аддитивные поля — можно в v1.
2. **Источник истины контракта — сгенерированный OpenAPI** (см. §23). Спека версионируется, лежит в
   репо, и по ней фронт генерирует типизированного клиента → рассинхрон ловится на сборке фронта.
3. **Минимальная версия клиента.** Бэкенд отдаёт заголовок/поле `X-Min-Client-Version`; фронт при
   несовместимости показывает «обновите приложение» (force-refresh web / update-стор для мобилы).
4. **Контракт-тест по спеке** в CI: реальные ответы эндпоинтов валидируются против OpenAPI-схемы
   (drift между кодом и спекой = красный CI).

### §22.B — Надёжность платёжных вебхуков
**Пробел:** вебхуки CloudPayments/ЮKassa бьют по каждому серверу владельца (firewall `webhooks`
публичный, stateless — уже есть). Не описаны подпись, идемпотентность, ретраи — а это **деньги**.
**Решения:**
1. **Проверка подписи** входящего вебхука (HMAC провайдера) — обязательна, иначе 401.
2. **Идемпотентность**: таблица обработанных вебхуков (по event-id провайдера); повтор — no-op с 200,
   чтобы провайдер перестал ретраить.
3. **Быстрый 200 + фон**: тяжёлую обработку — в Messenger (`async`), вебхук отвечает сразу.
4. **Ключи per-owner** (§18): у каждого владельца свой мерчант → свои `CLOUDPAYMENTS_*`/`YOOKASSA_*`.

### §22.C — 152-ФЗ и персональные данные (специфика РФ)
**Пробел:** продукт работает с ПД граждан РФ (телефоны клиентов, заказы). Не учтены требования по
локализации/хранению.
**Решения:**
1. **VM владельцев — в РФ** (ПД россиян хранится в РФ). Зафиксировать в размещении инвентаря.
2. **Редакция ПД в логах** (телефоны/имена маскируются) — правило monolog-процессора; логи в Loki с
   ограниченной ретенцией.
3. **Право на удаление/экспорт** ПД конкретного клиента — команда/эндпоинт; связано с оффбордингом
   владельца (§17.J) и ретенцией бэкапов.
4. **DPA/договорная база** между тобой (обработчик) и владельцем (оператор) — организационный пункт,
   но заложить в онбординг.

### §22.D — Гигиена зависимостей и CVE (иначе код «гниёт» за годы)
**Пробел:** не было процесса обновления зависимостей и отслеживания уязвимостей.
**Решения:**
1. **`composer audit`** (backend) и **`npm/pnpm audit`** (frontend) — шаг CI, падает на критичных CVE.
2. **Renovate/Dependabot** — авто-PR на обновления ядра и фронта; мерж после зелёного CI и canary.
3. **CVE ОС/пакетов** — `role: base` ставит unattended-security-upgrades; апгрейды ядра ОС/PHP —
   через canary (§17.L, RB-11).
4. **Кадэнс**: раз в месяц плановое обновление зависимостей + внеплановые security.

### §22.E — IP-экспозиция исходников ядра (следствие git-оверлея)
**Пробел (осознать явно):** git-оверлей кладёт **полный исходник ядра** на VM каждого владельца — тот,
кто имеет доступ к VM, видит весь код продукта. PHP не компилируется/не обфусцируется практично.
**Решения:**
1. **Принять как данность** выбранной упаковки (Часть I §0.1) — изоляция VM+БД важнее сокрытия кода.
2. **Юридическая защита**: лицензионные условия (запрет копирования/переиспользования ядра) в договоре
   с владельцем.
3. **Минимизация доступа к VM**: только `deploy`-ключ (§17.H), владелец без root по умолчанию (по
   договорённости). Если для конкретных «китов» нужна IP-изоляция — это уже иной контур (managed-доступ).
4. Зафиксировать в §15 как **сознательный компромисс**, не пробел.

### §22.F — Централизованные сервисы (нельзя делать per-server)
**Пробел:** часть возможностей физически не ложится на «сервер на владельца».
**Решения:**
1. **Push-уведомления (APNs/FCM)** — ключи и реле централизованы (control-plane или отдельный
   push-сервис): мобильное приложение одно (§17.I), токены устройств шлются в общий relay, который
   рассылает по владельцам. Data-plane дергает relay по API.
2. **Общий SMS/почтовый шлюз** — по умолчанию per-owner (свои ключи), но допускается общий аккаунт
   через центральный прокси, если у владельца нет своего (решение по тарифу).
3. **Глобальная аналитика по парку** (не ПД!) — агрегаты через heartbeat/метрики, не сырые данные.

### §22.G — Путь масштабирования одного владельца
**Пробел:** «1 VM на владельца» упирается в потолок, если ресторан крупный.
**Решения (порядок применения):**
1. **Вертикально** — больше CPU/RAM VM (проще всего).
2. **Разнести роли**: web / worker(Messenger) / Postgres на разные VM того же владельца (роли Ansible
   уже разделены — `app`/`postgres`/воркеры как юниты).
3. **Read-replica Postgres** + `pgbouncer` для чтения; вынести долгую аналитику на реплику.
4. Зафиксировать как **ступени**, а не преждевременную оптимизацию: включаем по метрикам (§17.C).

### §22.H — Фичефлаги / kill-switch ядра (runtime, без деплоя)
**Пробел:** capabilities/лицензия — про **платный доступ**; нужен ещё технический рубильник для новой
фичи ядра (выкатили код, но включаем постепенно / гасим при инциденте) **без** отката релиза.
**Решение:** лёгкие рантайм-флаги (значения в `WorkspaceSettings`/ENV, читаются через существующий
`SettingsReader`), дефолт — выкл; включение — данными, мгновенно, на конкретном сервере или по парку
(через control-plane). Отделяем «фича доступна по тарифу» (FeatureGate) от «фича технически включена»
(flag).

### §22.I — Блокировка одновременных деплоев
**Пробел:** `rollout.yml` (ядро) и `custom-deploy.yml` (кастом) могут пересечься на одном сервере.
**Решение:** файловый lock на сервере (`flock /opt/app/.deploy.lock`) вокруг любой раскатки; второй
процесс ждёт/падает с внятной ошибкой. Плюс в CI — concurrency-группа на владельца.

### §22.J — Fail-closed конфигурация
**Пробел:** недонастроенный сервер (нет обязательного ENV/лицензии) не должен тихо принимать трафик.
**Решение:** `/readyz` (§17.C) проверяет наличие обязательных ENV, доступность БД, применённость
миграций, валидность лицензии (или грейс). Нет — **не готов**, балансировщик/rollout не пускает трафик.
Стартовая валидация конфигурации — при прогреве кэша (падать явно, а не на первом запросе).

### §22.K — Пост-деплой синтетические/E2E проверки
**Пробел:** health/ready проверяют «жив», но не «работает бизнес-сценарий».
**Решение:** после смены symlink — синтетический smoke критичного пути (напр. создать тестовый заказ
в песочном воркспейсе → проверить статус → откатить). Провал = автооткат (как health, §8.4). Держать
маленький e2e-набор, гоняемый и в CI (на canary), и пост-деплоем.

### §22.L — Доставляемость и брендирование писем
**Пробел:** письма уходят с домена владельца; без SPF/DKIM попадут в спам; шаблоны не брендированы.
**Решения:**
1. **SPF/DKIM/DMARC** на домен владельца — шаг онбординга (§17.J), проверка в readyz/мониторинге.
2. **Брендирование писем** — шаблоны через namespace `@Custom` (§17.E) или значения из настроек (лого/
   цвета), одна кодовая база ядра.

## §23. OpenAPI: генерация спеки из кода (инструмент + контракт)

**Зачем в плане:** сгенерированная OpenAPI-спека — это **машинный контракт `/api/v1`** (§22.A):
источник типов для фронта, объект контракт-тестов, документация для владельцев-интеграторов. Поэтому
она — часть контура поддержки, а не «свагер для галочки».

**Пакет:** `nelmio/api-doc-bundle` (Symfony; под капотом `zircote/swagger-php`, атрибуты `#[OA\*]`).
Даёт JSON-спеку `/api/doc.json` и Swagger UI `/api/doc`, автоматически подхватывает роуты `/api/v1`.

**Решения по интеграции (детали и команды — в `backend/OPENAPI_SETUP.md`):**
1. **Область — только `^/api`** (админка EasyAdmin и системные роуты в спеку не идут).
2. **Публичность спеки:** `/api/doc*` — **закрыт** (dev или за ролью), чтобы не светить внутренние
   эндпоинты. Экспорт статической спеки — в CI.
3. **Экспорт в CI:** `bin/console nelmio:apidoc:dump --format=json > openapi.json` → артефакт
   релиза + коммит в репо контракта → фронт генерирует клиента, контракт-тест сверяет.
4. **Соглашение атрибутов:** каждый экшен `/api/v1` получает `#[OA\*]` (summary, теги по домену,
   request/response DTO, security bearer). Пустой ответ схемы = долг, ловится линтером.
5. **Security scheme `bearerAuth`** (JWT) объявляется глобально; публичные (`/auth`, `/webhooks`) —
   помечаются `security: []`.
6. **Overlay-эндпоинты** (`custom/`) тоже попадают в спеку (тот же скан `^/api`), но экспорт
   контракта ядра и контракта overlay — раздельными файлами (ядро стабильно, overlay — владельца).

---

---

# ЧАСТЬ IV. РОССИЙСКИЙ СТЕК (импортозамещение) (2026-07-15)

**Требование:** вся инфраструктура и ops-контур — **только российские сервисы**. Явно названы
**GitVerse** (git+CI) и **Timeweb** (облако), «и другие». Эта часть **переопределяет** упоминания
конкретных инструментов в Частях I–III: где в плане стоял GitHub / S3 / Grafana / Sentry / Let's
Encrypt / APNs-FCM — читать по карте ниже. Архитектурные решения (git-оверлей, push-раскатка Ansible,
control-plane, single-tenant) **не меняются** — меняются только провайдеры под ними.

## §24. Карта замен (foreign → российское)

| Область | Было в плане (Ч. I–III) | Российская замена (дефолт) | Альтернативы РФ |
|---------|-------------------------|----------------------------|-----------------|
| Git-хостинг репозиториев | GitHub | **GitVerse** (gitverse.ru, SberTech) | GitFlic |
| CI/CD (проверки + запуск раскатки) | GitHub Actions | **GitVerse CI/CD** | GitFlic CI; self-hosted раннеры |
| VM/облако для парка и control-plane | (абстрактные VM) | **Timeweb Cloud** | Yandex Cloud, Selectel, VK Cloud, Cloud.ru |
| Объектное хранилище бэкапов (оффсайт) | S3 | **Timeweb Object Storage** (S3-совм.) | Yandex Object Storage, Selectel |
| Managed PostgreSQL (опция вместо локальной БД) | — | **Timeweb Managed PostgreSQL** | Yandex Managed PostgreSQL |
| Метрики/дашборд | Prometheus+Grafana | **VictoriaMetrics** (+ его UI) / **Zabbix** | Yandex Monitoring, Timeweb-мониторинг |
| Логи | Loki+promtail | **VictoriaLogs** (self-host на RF-инфре) | Yandex Cloud Logging |
| Трекинг ошибок | Sentry | **self-hosted** трекер на **RF-инфре** | Yandex-native логи ошибок |
| Секреты/KMS | (ansible-vault) | **ansible-vault** (OSS, self-host) | **Yandex KMS**, Cloud.ru KMS |
| Push-уведомления (мобилки) | APNs/FCM | **RuStore Push (VK)** | (iOS — см. §26) |
| Магазин приложений | App Store/Google Play | **RuStore** | Google Play (доп.), App Store (см. §26) |
| Транзакционная почта | (SMTP) | **Unisender / Mailopost / Sendsay** | Yandex 360, VK WorkMail |
| SMS | SMS_API_* | **SMSC.ru / SMS.ru** (уже РФ) | — |
| Платежи | CloudPayments/ЮKassa | **уже РФ** | Тинькофф Касса, Сбербанк |
| POS-интеграции | iiko/rkeeper | **уже РФ** | — |
| DNS-хостинг | (ACME/DNS) | **Timeweb DNS / Yandex Cloud DNS** | RU-CENTER (nic.ru), reg.ru |
| Публичный TLS | Let's Encrypt | **Let's Encrypt (оставляем)** — авто-выпуск и **авто-обновление** на каждом сервере (см. §26.2) | — (других вариантов нет) |
| Config-management | Ansible | **Ansible** (OSS, self-host — не внешний сервис) | — |
| Realtime hub | Mercure | **Mercure** (OSS, self-host) | — |
| Обновление зависимостей | Dependabot/Renovate | **Renovate self-hosted** (работает с GitVerse) | ручной кадэнс |

**Правило:** self-hosted OSS (Ansible, Mercure, PostgreSQL, Caddy/nginx, VictoriaMetrics/Logs, Zabbix,
Renovate) — допустим, т.к. это не внешний сервис, а софт, работающий **на твоей RF-инфре**. Запрещены —
именно **внешние SaaS** вне РФ (GitHub, облачный Sentry, EAS Build, LE как жёсткая зависимость и т.п.).

## §25. Дельты к плану по разделам

- **Репозитории (§3).** `delivery-core`, `delivery-custom-*`, `delivery-infra`, `delivery-control-plane`
  — все на **GitVerse**. Серверы `git clone`/pull ядра и overlay **с GitVerse** по SSH (deploy-key).
- **CI/CD (§9, §22.A/§23).** Пайплайн описывается конфигом **GitVerse CI/CD** (шаги те же: composer
  install → cs-fixer/phpstan → lint:container → schema:validate → phpunit+boundary → `composer audit`
  → `nelmio:apidoc:dump`; на master: тег → регистрация релиза в control-plane → `ansible-playbook`).
  Точный синтаксис конфига GitVerse CI **сверить по их докам** — шаги остаются shell-командами.
  SSH-ключ раскатки и vault-пароль — в секретах GitVerse (аналог Environments/approval).
- **Раскрутка серверов (§8).** VM создаёшь в **Timeweb Cloud** (или Yandex/Selectel), затем
  `provision.yml`. БД — локальный PostgreSQL на VM **или** Timeweb Managed PostgreSQL (тогда в
  `shared/.env` только DSN).
- **Бэкапы/DR (§17.B / O2).** Оффсайт — **Timeweb Object Storage** (S3-совместимый: `pgBackRest`/
  `restic` работают как есть). Хранилище — в **другом** регионе/провайдере РФ, чем VM владельца.
- **Наблюдаемость (§17.C / O3).** Метрики — **VictoriaMetrics** + `node_exporter`/`postgres_exporter`;
  логи — **VictoriaLogs** (или Zabbix для «всё-в-одном» мониторинг+алерты); ошибки — self-hosted
  трекер. Всё на RF-инфре (свой мониторинг-сервер рядом с control-plane).
- **Секреты (§11 / §17.H / O5).** `ansible-vault` (OSS) + опционально **Yandex KMS**/Cloud.ru KMS для
  мастер-ключей. Никаких зарубежных секрет-менеджеров.
- **Фронтенд (§17.I / O7).** Сборка web — на **GitVerse CI** (self-host RN/web-бандл, **без Expo EAS**).
  Распространение мобильного приложения — **RuStore**; push — **RuStore Push**. npm-зависимости — через
  **self-hosted npm-прокси** (Verdaccio на RF-инфре) для независимости от npmjs.
- **Централизованные сервисы (§22.F).** Push-реле — на **RuStore Push (VK)**; общий почтовый/SMS-шлюз
  (если нужен) — RF-провайдеры из §24.
- **Гигиена зависимостей (§22.D).** `composer audit`/`pnpm audit` в CI; **Renovate self-hosted**
  против GitVerse; supply-chain — **self-hosted кэш-прокси** для composer (Satis/собственный) и npm
  (Verdaccio), чтобы сборки не зависели от доступности зарубежных реестров.

## §26. Честные жёсткие ограничения (где чистой RF-замены нет)

Не выдаю желаемое за действительное — фиксирую то, что нельзя полностью «заместить», и как митигируем:

1. **Реестры пакетов (packagist, npmjs).** Сами пакеты — зарубежный OSS; загрузка идёт с
   зарубежных реестров. **Митигация:** self-hosted **кэширующий прокси/зеркало** на RF-инфре
   (composer: Satis/собственный proxy; npm: Verdaccio) + **вендоринг** критичных зависимостей
   (коммит `vendor`/зеркало), чтобы прод-сборки были независимы от зарубежной доступности. Полностью
   «российскими» исходники зависимостей не станут — цель здесь **независимость доступности**, не
   происхождение кода.
2. **Публичный TLS — оставляем Let's Encrypt** (решение владельца: других вариантов сертификатов
   нет — нац. УЦ Минцифры доверяется в основном Яндекс.Браузером и не подходит для широкой
   аудитории). Это **сознательно допущенное исключение** из «только РФ» для TLS.
   **Требование — авто-обновление на каждом сервере**, реализуется в `provision`/`base`-роли:
   - **Дефолт — Caddy** (уже фигурирует в §15/§8): выпускает и **сам продлевает** сертификаты
     через ACME, отдельного крона не нужно — рекомендуемый путь, минимум операций;
   - **Альтернатива — nginx + certbot**: `certbot` с `--nginx`/webroot + **системный таймер**
     (`certbot.timer` или `systemd`-таймер `certbot renew --quiet` раз в 12 ч) — авто-продление,
     `--deploy-hook "systemctl reload nginx"`.
   Роль Ansible ставит выбранный вариант и проверяет продление (dry-run `certbot renew --dry-run` /
   мониторинг срока действия — алерт из §17.C, чтобы протухший серт был виден заранее).
   ACME-валидация (HTTP-01/DNS-01) требует исходящего доступа к LE — учесть в firewall.
3. **iOS push (APNs).** Для приложений в App Store доставка push на iPhone идёт **только через APNs
   Apple** — российской замены нет. **Митигация:** Android/RuStore — через **RuStore Push**; для iOS
   либо принять зависимость APNs, либо распространять iOS-приложение вне App Store (ограниченно). Это
   **осознанное ограничение платформы Apple**, а не пробел плана.
4. **Expo EAS Build.** Облачная сборка Expo — зарубежный сервис. **Митигация:** собирать React Native
   локально/на **GitVerse CI** (bare workflow), без EAS.

Каждое из этих ограничений вынесено в §15/§21 как «сознательный компромисс платформы», с указанной
митигацией, чтобы при поддержке годами решение было прослеживаемым.

---

**Итог (Части I + II + III + IV):** план даёт (1) общий core с авто-раскаткой master→canary→prod,
(2) изолированный overlay владельца, переживающий обновления ядра, (3) де-слугификацию за счёт
single-tenant модели, (4) гейт совместимости + deprecation-цикл + явную поверхность API (+ OpenAPI как
машинный контракт), чтобы обновления **гарантированно** не ломали клиентов, (5) полный ops-контур:
воркеры/крон/Mercure, бэкапы/DR, наблюдаемость, безопасность и радиус поражения, фронтенд,
онбординг/оффбординг, runbooks, (6) закрытые «долгие» риски: версионирование API и рассинхрон
фронт/бэк, вебхуки, 152-ФЗ/ПД, гигиену зависимостей/CVE, IP-экспозицию, централизованные сервисы,
масштабирование, фичефлаги, deploy-lock, fail-closed, e2e, доставляемость писем, и (7) **полностью
российский стек** (GitVerse, Timeweb, VictoriaMetrics/Zabbix, RuStore, RF-почта/DNS/KMS) с честно
зафиксированными исключениями платформ (реестры пакетов; **Let's Encrypt оставлен для TLS с
авто-обновлением на каждом сервере**; iOS-push через APNs; сборка вместо EAS).

**Порядок реализации:** фичевые фазы 0→7, ops-фазы O1→O8 (**O1–O3 обязательны до первого боевого
владельца**), «долгие» пункты §22 подключаются к профильным фазам (§22.A/§23→Фаза 5+O6; §22.B→платежи;
§22.C→O2/O8; §22.D→CI; §22.F→Фаза 6), а российский стек Части IV применяется **сквозно во всех фазах**
при выборе провайдеров. Каждая фаза самодостаточна и заканчивается зелёными проверками.
