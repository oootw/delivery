# Домен Authorize — как работает

Домен отвечает за идентичность пользователя и вход по номеру телефона: выпуск SMS-кода,
проверку кода, выдачу пары JWT (access + refresh), их ротацию и logout. Namespace
`App\Application\Authorize\...` (прикладной слой — без Doctrine и HTTP). Doctrine-сущности и
репозитории — в `App\Infrastructure\Doctrine\Domain\Authorize`, HTTP-экшены — в
`App\Http\Action\Authorize`. Все пути ниже относительны `backend/`.

Логин пользователя — **номер телефона** (естественный ключ). Пароля у обычного пользователя
нет; пароль и флаг `isAdmin` живут только в Doctrine-сущности `User` и нужны для входа в
админку (домен здесь их не моделирует). Это канонический домен пользователя для всего проекта —
`customerId`/`userId` в остальных доменах приходят из JWT, выданного здесь.

## 1. Эндпоинты

HTTP-слой — Symfony-контроллеры-Action с атрибутами `#[Route]`, префикс `/api/v1/auth`
(`config/routes.yaml`, отдельная секция `authorize_controllers`). Файрвол `api_auth`
(`^/api/v1/auth`) — **stateless, публичный** (без JWT): сюда ещё нельзя прийти с токеном.

| Метод | Роут | Экшен | Назначение |
|-------|------|-------|-----------|
| POST | `/api/v1/auth/get-auth-code` | `GetAuthCodeAction` | Запросить SMS-код на телефон |
| POST | `/api/v1/auth/` | `AuthorizeAction` | Войти по коду → пара токенов |
| POST | `/api/v1/auth/sign-up` | `SignUpAction` | Регистрация нового номера → пара токенов |
| POST | `/api/v1/auth/refresh-tokens` | `RefreshTokensAction` | Обновить пару токенов по refresh |
| POST | `/api/v1/auth/logout` | `LogoutAction` | Отозвать токены сессии |

Все остальные `/api/v1/**` защищены файрволом `api` с `JwtAuthenticator` — токен, выданный
этим доменом, там и проверяется.

## 2. Карта компонентов

```
Authorize/
├─ Entity/                          сущности + порты репозиториев (без инфраструктуры)
│  ├─ User/    User (id + phone) + UserRepositoryInterface (findByPhone/create/promoteToAdmin)
│  ├─ Code/    Code + CodeRepositoryInterface + CodeTypeEnum (register | authorize)
│  └─ Token/   Token (сессия refresh) + TokenRepositoryInterface (save/revokeBySessionId)
│
├─ Command/                         use-case'ы записи ({UseCase}Command + Handler)
│  ├─ CreateAuthorizeCode             выпуск одноразового кода на телефон
│  ├─ CheckOntimeCode                 проверка кода (при неверном — \DomainException)
│  ├─ CreateUser                      регистрация нового пользователя по телефону
│  ├─ CreateAuthorizeTokens           генерация пары JWT + сохранение refresh-сессии
│  ├─ Logout                          отзыв токенов сессии
│  └─ GrantAdmin                      выдать роль админа + пароль (консоль app:admin:grant)
│
├─ Query/                           use-case'ы чтения (Query + Fetcher), DTO рядом
│  ├─ FindUserByPhone                 поиск пользователя по номеру (nullable)
│  ├─ GetSmsCode                      отправка сообщения с кодом через SmsSenderInterface
│  ├─ GetSmsCodeSendAvailable         кулдаун: код по номеру ещё не «свежий»
│  ├─ GetSmsDailyLimitAvailable       суточный лимит запросов кода (10/сутки)
│  └─ GetRefreshTokensAvailable       валидация refresh-токена → claims (phone, sessionId)
│
├─ Events/    OnBeforeSaveNewUser / OnAfterSaveNewUser  (хуки регистрации)
├─ Gateway/   SmsSenderInterface       порт отправки SMS
├─ Security/  PasswordHasherInterface  порт хеширования пароля (для админа)
└─ Service/   CreateUniqueCodeService  генерация уникального кода
```

**Порты и адаптеры:**

| Порт | Реализация |
|------|-----------|
| `UserRepositoryInterface` / `CodeRepositoryInterface` / `TokenRepositoryInterface` | `Infrastructure/Doctrine/Domain/Authorize/{User,Code,Token}` |
| `SmsSenderInterface` | SMS-провайдер (Infrastructure) |
| `PasswordHasherInterface` | Symfony PasswordHasher (Infrastructure/Security) |
| JWT-выпуск/проверка | `Shared/Service/JWTManager/JWTManager` + `Http/Security/JwtAuthenticator` (файрвол `api`) |

## 3. Поток: POST `/auth/get-auth-code` (запрос кода)

Вход: `{ phone, codeType: "register" }`. `GetAuthCodeAction`:

```
[1] суточный лимит по номеру (GetSmsDailyLimitAvailable, 10/сутки) — ДО ветвления по юзеру
[2] кулдаун (GetSmsCodeSendAvailable): предыдущий код по номеру уже не «свежий»
[3] CreateAuthorizeCode — код выпускается ВСЕГДА (даже для незарегистрированного номера)
[4] FindUserByPhone: пользователь есть → GetSmsCode отправляет SMS; нет → SMS не уходит (decoy)
```

Ключевое — **защита от enumeration**: лимит, кулдаун и тайминг одинаковы независимо от того,
зарегистрирован номер или нет. Для незарегистрированного номера код всё равно выпускается
(«decoy»), но SMS не отправляется — эндпоинт не работает оракулом существования аккаунта.
Ответ всегда `success()`.

## 4. Поток: POST `/auth/` (вход по коду)

Вход: `{ phone, code }`. `AuthorizeAction`:

```
[1] FindUserByPhone (nullable, пока не раскрываем результат)
[2] CheckOntimeCode(codeType=authorize) — неверный код → \DomainException «Неверный код»
[3] сюда дошли с верным кодом; user === null → тот же ответ «Неверный код» (enumeration)
[4] CreateAuthorizeTokens → пара JWT
```

Ответ: `{ access_token, refresh_token, expires_in }`.

**Регистрация** (`/auth/sign-up`): номер не должен существовать (`USER_EXIST` иначе) →
`CreateUser` → сразу `CreateAuthorizeTokens`. Тот же формат ответа.

## 5. Токены и сессии (`CreateAuthorizeTokens`)

`CreateAuthorizeTokensHandler` → `JWTManager::generateTokenPair(userId, phone, sessionId)`:

- новый `sessionId` (UUID) на каждую выдачу пары;
- refresh-токен сохраняется как `Token` (сессия) в БД с `expiresAt` — refresh **ротируемый и
  отзываемый**;
- при `revokePreviousToken` (refresh-поток) старая сессия по `sessionId` отзывается перед выдачей.

**Refresh** (`/auth/refresh-tokens`): `GetRefreshTokensAvailable` валидирует токен → claims
(`phone`, `sessionId`) → `FindUserByPhone` → `CreateAuthorizeTokens(revokePreviousToken: true)`
(ротация: старая сессия гасится). Ошибка → `401`. **Logout** (`/auth/logout`) отзывает токены
сессии.

## 6. Админ (`GrantAdmin`)

Не HTTP, а консольная команда `app:admin:grant <phone> <password>`: если пользователя нет —
создаёт, затем `promoteToAdmin` (роль `ROLE_ADMIN` + хешированный пароль). Вход в EasyAdmin —
отдельный сессионный файрвол `admin` (`^/admin`, form_login по телефону+паролю, только
`isAdmin = true`). См. домены/инфраструктуру админки (EasyAdmin).

## 7. Файрволы (`config/packages/security.yaml`)

| Файрвол | Паттерн | Режим |
|---------|---------|-------|
| `api_auth` | `^/api/v1/auth` | stateless, публичный (выпуск токенов) |
| `webhooks` | `^/api/v1/webhooks` | stateless, публичный (вебхуки платежей) |
| `api` | `^/api/v1` | stateless, `JwtAuthenticator` (все защищённые эндпоинты) |
| `admin` | `^/admin` | сессия, form_login, `ROLE_ADMIN` |

## 8. Ограничения / TODO

- 🔴 **Верификация кода застаблена** (баг #15): `CodeRepository::validateCode` /
  `validateCodeByCreatedAt` пока возвращают `true` всегда — любой SMS-код проходит, кулдаун по
  проверке кода не работает. WIP-скелет, требует согласования (одноразовость / срок жизни /
  число попыток). Каркас `CheckOntimeCode` и защита от enumeration уже на месте.
- Суточный лимит SMS реализован (10/сутки); счётчик-enumeration (остаток #10) — не закрыт.
- Профиль/имя пользователя доменом не моделируются: контактные данные (имя, телефон, адрес)
  фиксируются снимком в заказе (домен `Order`), а не в `User`.
