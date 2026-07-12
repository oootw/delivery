# Домен Workspace — как работает

Домен моделирует «рабочее пространство» арендатора (tenant) и его команду: воркспейс с
уникальным `slug`, владельца и участников-персонал. Namespace `App\Application\Workspace\...`
(прикладной слой — без Doctrine и HTTP). Doctrine-сущности и репозитории — в
`App\Infrastructure\Doctrine\Domain\Workspace`, HTTP-экшены — в `App\Http\Action\Workspace`.
Все пути ниже относительны `backend/`.

Воркспейс — корень мультитенантности: `workspace_id` проставлен во всех бизнес-доменах
(Venue, Menu, Order, Promotion, Loyalty…), репозитории фильтруют по нему. Право владельца
= **активная подписка** владельца (отдельного флага нет). Резолв воркспейса по запросу — по
поддомену `slug.app.com` (`Http/Workspace/WorkspaceContext`).

## 1. Эндпоинты

HTTP-слой — Symfony-контроллеры-Action с `#[Route]`, префикс `/api/v1`, файрвол `api` (JWT).

| Метод | Роут | Экшен | Назначение |
|-------|------|-------|-----------|
| POST | `/api/v1/workspaces` | `CreateWorkspaceAction` | Создать воркспейс (нужна активная подписка) |
| GET | `/api/v1/workspaces` | `GetMyWorkspacesAction` | Воркспейсы, где я участник |
| POST | `/api/v1/workspaces/{workspaceId}/staff` | `AddStaffMemberAction` | Добавить сотрудника по телефону |
| DELETE | `/api/v1/workspaces/{workspaceId}/staff/{staffUserId}` | `RemoveStaffMemberAction` | Убрать сотрудника (владельца нельзя) |

## 2. Карта компонентов

```
Workspace/
├─ Entity/
│  ├─ Workspace/   Workspace (id/name/slug/description/logo?/ownerId) + WorkspaceRepositoryInterface
│  │              (save/findById/findBySlug/findAllByIds/countByOwner); buildNew/rename/attachLogo
│  └─ Membership/  Membership (workspaceId+userId+role) + MembershipRepositoryInterface
│                  MembershipRoleEnum: owner | staff; buildOwner/buildStaff/isOwner
│
├─ Command/
│  ├─ CreateWorkspace     подписка → лимит тарифа → slug → воркспейс + owner-membership (в транзакции)
│  ├─ AddStaffMember      добавить сотрудника по телефону (только владелец)
│  └─ RemoveStaffMember   убрать сотрудника (владельца удалить нельзя)
│
├─ Query/
│  └─ GetWorkspacesByMemberUserId   воркспейсы, где пользователь состоит участником → WorkspaceDTO
│
└─ Service/
   ├─ WorkspaceAccess    общий гейт доступа для хендлеров всех доменов (см. §5)
   └─ WorkspaceSlugRule  правила slug: 3–63, /^[a-z0-9]+(?:-[a-z0-9]+)*$/, резерв-лист
```

**Порты и адаптеры:** `WorkspaceRepositoryInterface` / `MembershipRepositoryInterface` →
`Infrastructure/Doctrine/Domain/Workspace`. Миграция `Version20260708130000` (`workspace`,
`workspace_membership`). Логотип хранится JSON-колонкой (VO `ImageValueObject`), nullable
при создании.

## 3. Slug (`WorkspaceSlugRule`)

Строгий и **неизменяемый** идентификатор арендатора:

- длина 3–63; формат `/^[a-z0-9]+(?:-[a-z0-9]+)*$/` (нижний регистр, цифры, дефисы внутри —
  без крайних дефисов и двойных);
- резерв-лист служебных имён (`www`, `api`, `admin`, …);
- уникальность проверяется при создании (`findBySlug`), в БД — уникальный индекс.

Slug служит поддоменом (`slug.app.com`) — по нему `WorkspaceContext` резолвит воркспейс запроса
(в dev fallback через заголовок `X-Workspace-Slug`, только при `kernel.debug`).

## 4. Поток: POST `/workspaces` (создание)

`CreateWorkspaceHandler` (последовательность важна):

```
[1] активная подписка владельца (subscriptions->findActiveByUser) — иначе SUBSCRIPTION_REQUIRED
[2] лимит воркспейсов по тарифу (TarifLimits->maxWorkspaces) — иначе WORKSPACE_LIMIT_REACHED
[3] формат slug (WorkspaceSlugRule->validate)
[4] уникальность slug (findBySlug) — иначе WORKSPACE_SLUG_TAKEN
[5] TransactionInterface->wrap: save(workspace) + save(owner-membership) атомарно
    (иначе возможен осиротевший воркспейс без владельца)
```

Ответ (`CreatedWorkspaceDTO`): `id`, `slug`.

## 5. Гейт доступа (`Service/WorkspaceAccess`) — общий для всех доменов

`WorkspaceAccess` — единственная точка авторизации по воркспейсу, её зовут хендлеры Venue,
Menu, Order, Promotion, Loyalty и т.д.:

| Метод | Что проверяет | Кому |
|-------|--------------|------|
| `getOwnedWorkspace(workspaceId, userId)` | воркспейс существует, `userId` — владелец, **и подписка активна** | мутации (~28 use-case'ов) |
| `requireMember(workspaceId, userId)` | пользователь — участник (owner/staff) | чтение |
| `requireActiveWorkspace(workspaceId)` | у воркспейса активная подписка | гостевые заказы (`PlaceOrder`) |

Так подписочный enforcement централизован: воркспейс без оплаченной подписки не может ни менять
данные (владелец), ни принимать заказы (витрина «гаснет»).

## 6. Команда (`Membership`)

- Роли `owner` / `staff` (`MembershipRoleEnum`). Владелец создаётся при создании воркспейса.
- `AddStaffMember` — по номеру телефона (владелец добавляет сотрудника).
- `RemoveStaffMember` — владельца удалить нельзя.
- Просмотр меню/точек доступен любому участнику (`requireMember`), мутации — только владельцу
  (`getOwnedWorkspace`).

## 7. Ограничения / TODO

- Лимит воркспейсов задан политикой `Tarif/Service/TarifLimits` (сейчас 1 на всех тарифах),
  **не в БД** — таблицы тарифов пока нет ни в одной миграции.
- `GetWorkspaceBySlug` + обогащение `WorkspaceContext` (slug → id) вынесены в отдельный шаг
  клиентской витрины (домен `Menu` уже резолвит воркспейс по slug для `/api/v1/menu/**`).
- Slug неизменяем после создания; переименование меняет только `name`/`description` (`rename`).
