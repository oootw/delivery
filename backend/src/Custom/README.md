# src/Custom — клиентские модули кастомизации

Здесь живёт **платный локальный кастом** под конкретных владельцев/воркспейсы. Каждый клиент —
одна папка `src/Custom/{slug}/`. Ядро (`App\Application`, `App\Infrastructure`, `App\Http`)
**никогда** не ссылается на `App\Custom\*` — это проверяет тест
`tests/Unit/Architecture/CustomizationBoundaryTest`. Общая архитектура и план — в
`backend/PLAN_CUSTOMIZATION.md`.

## Как устроен модуль

```
src/Custom/Acme/
├─ AcmeModule.php                  # implements App\Application\Customization\Contract\CustomModuleInterface
├─ Application/{Domain}/…          # новые use-case'ы, сущности, стратегии
├─ Infrastructure/…               # Doctrine-маппинги, адаптеры портов
├─ Http/Action/…                  # кастомные эндпоинты (см. «Роутинг»)
├─ Http/Admin/…                   # кастомные EasyAdmin CRUD (срез 3)
├─ migrations/                    # таблицы custom_{slug}_*
└─ Resources/config/services.yaml # DI-проводка модуля при необходимости
```

Класс-манифест (`{Slug}Module`) реализует `CustomModuleInterface` и автоматически получает тег
`app.custom_module` (через `_instanceof` в `config/services.yaml`) — его подхватывает
`CustomModuleRegistry`. Правило зависимостей: `App\Custom\*` может зависеть от `App\Application`
и `App\Shared`, но не наоборот.

## Активация — это данные, а не код

Наличие папки не включает кастом. Модуль активен на воркспейсе, только когда в таблице
`workspace_custom_module` есть включённая запись `(workspace_id, slug)`. Снять клиента =
отключить/удалить запись; код можно удалить позже, ядро не затрагивается.

## Роутинг

`config/routes.yaml` сканирует `../src/Custom/` с префиксом `/api/v1` (ресурс
`custom_controllers`). Роут получают только классы `Http/Action/*` с атрибутом `#[Route]`.
Кастомный экшен сам гейтит доступ (`CustomAccess::assertModuleActive` + `assertRole`) и при
отсутствии прав отдаёт `400`/`404`. Эндпоинты под `/api/v1` требуют JWT (файрвол `api`).

## Doctrine и миграции

- Сущности модуля — в `src/Custom/{slug}/Infrastructure/Doctrine`. Их разом подхватывает
  маппинг `Custom` в `config/packages/doctrine.yaml` (`prefix: App\Custom`, `dir: src/Custom`) —
  отдельная запись на модуль не нужна.
- Миграции кастомных таблиц лежат в общей `migrations/` (единая история, один `migrate`),
  таблицы именуются `custom_{slug}_*`. Это осознанно проще, чем миграции-на-модуль в монорепо.

## Разделы админки

Класс в `src/Custom/{slug}/Http/Admin`, реализующий
`App\Http\Admin\CustomAdminMenuContributorInterface` (тег `app.custom_admin_menu`), добавляет
пункты в глобальную админку; `DashboardController` собирает их, не зная про клиентские классы.
EasyAdmin CRUD-контроллеры модуля — там же.

## Настройки и роли

- Настройки модуля — класс, реализующий `SettingsProviderInterface` (ключи префиксуются slug'ом),
  читаются через `WorkspaceSettingsReader`.
- Роли модуля объявляются в `CustomModuleInterface::roles()`, назначаются
  `POST /api/v1/workspaces/{id}/custom-roles`, проверяются `CustomAccess::hasRole` (владелец
  имеет все роли активных модулей).

## Соглашения

- Slug папки = `CustomModuleInterface::slug()` = префикс таблиц `custom_{slug}_*`; при
  переименовании — `previousSlugs()`, чтобы активации не «слетели».
- Пример-эталон — модуль `Acme` (бронирование столов): сущность+миграция, эндпоинты, роль,
  раздел админки, настройка.
- У каждого модуля свои тесты, не зависящие от тестов ядра.
