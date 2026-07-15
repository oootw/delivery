# OpenAPI из кода — установка и настройка (NelmioApiDocBundle)

Генерируем OpenAPI-спеку `/api/v1` **из кода** (роуты + атрибуты `#[OA\*]`). Спека — машинный
контракт API (см. `PLAN_FLEET.md` §22.A/§23): типы для фронта, объект контракт-тестов, документация.

> ⚠️ Пакет **не установлен** автоматически: среда, где готовился этот файл, была без сети (DNS к
> packagist заблокирован). Ниже — точные шаги; установка = одна команда при наличии сети. Все
> конфиги ниже уже подогнаны под этот проект (firewalls `api`/`api_auth`/`webhooks`, префикс `/api/v1`).

Пакет: **`nelmio/api-doc-bundle`** (Symfony), под капотом `zircote/swagger-php` (атрибуты `#[OA\*]`).
Даёт JSON `/api/doc.json` и Swagger UI `/api/doc`; сам подхватывает роуты `#[Route]`.

---

## 1. Установка

```bash
cd backend
composer require nelmio/api-doc-bundle
# Swagger UI использует ассеты asset-mapper — если UI нужен:
php bin/console importmap:require swagger-ui   # опционально, только для /api/doc
```

Symfony Flex сам зарегистрирует бандл в `config/bundles.php` и положит дефолтные
`config/packages/nelmio_api_doc.yaml` и `config/routes/nelmio_api_doc.yaml`. **Замени** их
содержимое на подогнанное ниже (шаги 2–4).

> Если Flex спросит про рецепт — прими, потом перезапиши файлы. Если версия не резолвится под
> Symfony 8.1 — поставь совместимую (`composer require nelmio/api-doc-bundle:^5` или `*` и дай
> composer выбрать).

---

## 2. `config/packages/nelmio_api_doc.yaml` (подогнано под проект)

```yaml
nelmio_api_doc:
    documentation:
        info:
            title: Delivery API
            description: HTTP API ядра (/api/v1). Контракт с фронтендом и интеграторами.
            version: 1.0.0            # держи в синхроне с core-contract.json (см. PLAN_FLEET §7)
        components:
            securitySchemes:
                bearerAuth:
                    type: http
                    scheme: bearer
                    bearerFormat: JWT
        security:
            - bearerAuth: []          # по умолчанию все эндпоинты требуют JWT (firewall `api`)
    areas:                            # в спеку идёт ТОЛЬКО /api, без админки/системных роутов
        default:
            path_patterns:
                - ^/api/v1
            disable_default_routes: true
```

Публичные эндпоинты (`^/api/v1/auth`, `^/api/v1/webhooks`) в самих экшенах помечай
`#[OA\...(security: [])]`, чтобы снять глобальный `bearerAuth`.

---

## 3. `config/routes/nelmio_api_doc.yaml` (спека закрыта от публики)

```yaml
# JSON-спека — источник для CI-экспорта и контракт-тестов. В prod закрыта (см. security ниже).
app.swagger.json:
    path: /api/doc.json
    methods: [GET]
    defaults: { _controller: nelmio_api_doc.controller.swagger }

# Swagger UI — только для dev (в prod не публикуем внутренние эндпоинты).
app.swagger.ui:
    path: /api/doc
    methods: [GET]
    defaults: { _controller: nelmio_api_doc.controller.swagger_ui }
    condition: "env('APP_ENV') === 'dev'"
```

---

## 4. `config/packages/security.yaml` — доступ к спеке

Спека раскрывает поверхность API → **не оставляй её публичной**. Добавь в `access_control`
(до строки `- { path: ^/api/v1, roles: IS_AUTHENTICATED_FULLY }`):

```yaml
        # OpenAPI: UI только dev; JSON — под ролью (или закрыть совсем, экспорт делаем в CI).
        - { path: ^/api/doc, roles: PUBLIC_ACCESS }   # dev-условие в routes; в prod роут не создаётся
```

> В `dev` firewall уже пропускает `_profiler|assets|build`; путь `/api/doc` обслуживается обычным
> `main`/`api`. Проще всего: UI живёт только в dev (шаг 3), а машинную спеку в prod **не публиковать
> вовсе** — генерировать в CI командой `nelmio:apidoc:dump` (шаг 6). Тогда строку выше можно не
> добавлять, а `/api/doc.json` тоже закрыть `condition: dev`.

---

## 5. Соглашение по атрибутам `#[OA\*]` на экшенах

Каждый экшен `/api/v1` документируем. Пример на реальном экшене
`src/Http/Action/Loyalty/GetLoyaltyHistoryAction.php`:

```php
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;

#[OA\Get(
    path: '/api/v1/loyalty/history',
    summary: 'История начислений/списаний бонусов клиента',
    tags: ['Loyalty'],
    parameters: [
        new OA\QueryParameter(name: 'workspace_id', required: true, schema: new OA\Schema(type: 'integer')),
        new OA\QueryParameter(name: 'limit', required: false, schema: new OA\Schema(type: 'integer', default: 50)),
    ],
    responses: [
        new OA\Response(response: 200, description: 'OK'),
        new OA\Response(response: 400, description: 'Некорректный запрос'),
        new OA\Response(response: 401, description: 'Нет/невалидный JWT'),
    ],
)]
#[Route('/loyalty/history', name: 'app_get_loyalty_history', methods: ['GET'])]
public function handle(Request $request): Response { /* ... */ }
```

Правила:
- **tags** = имя домена (`Loyalty`, `Order`, `Menu`, …) — так спека группируется по доменам.
- Для тел запросов/ответов используй `#[OA\JsonContent(ref: new Model(type: SomeDto::class))]`, где
  DTO — существующие Response/Query DTO проекта (Nelmio читает типы из PHP).
- **Публичные** экшены (`Authorize/`, `webhooks/`) — `security: []` в атрибуте.
- **Overlay-эндпоинты** (`custom/`) документируются так же; они попадают в спеку через тот же
  скан `^/api/v1`.

---

## 6. Экспорт спеки в CI (машинный контракт)

Добавь шаг в CI ядра (`.github/workflows/ci.yml`) и в релиз:

```bash
php bin/console nelmio:apidoc:dump --format=json > openapi.json
# опубликовать как артефакт релиза И/ИЛИ закоммитить в репо-контракт для фронта
```

Использование:
- **Фронт** генерирует типизированного клиента из `openapi.json` (напр. openapi-typescript / orval).
- **Контракт-тест** (PLAN_FLEET §22.A.4): в CI прогоняем реальные ответы против `openapi.json`
  (валидатор схемы) — расхождение код↔спека = красный CI.
- **Версия спеки** синхронизируется с `core-contract.json` (§7): ломающее изменение → мажор → `/api/v2`.

---

## 7. Проверка после установки

```bash
php bin/console debug:router | grep -E 'api/doc'          # роуты спеки на месте
php bin/console nelmio:apidoc:dump --format=json | head    # спека генерится
php bin/console lint:container                             # контейнер собирается
# dev: открыть http://localhost:8000/api/doc — Swagger UI со всеми /api/v1
```

**DoD:** `nelmio:apidoc:dump` отдаёт валидный OpenAPI со всеми `/api/v1`; админка/системные роуты в
спеку не попали; публичные эндпоинты помечены `security: []`; UI закрыт в prod; экспорт встроен в CI.
