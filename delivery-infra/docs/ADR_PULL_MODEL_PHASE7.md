# ADR_PULL_MODEL_PHASE7

## Статус

Accepted (design-only). Реализация pull-модели **не входит** в текущий rollout Фазы 7.

## Контекст

Сейчас production-поток построен на push-модели:
- CI регистрирует релиз в control-plane;
- Ansible запускает `release.yml` (canary -> bake -> production);
- inventory загружается из `inventory/production` (dynamic plugin + static fallback);
- аудит раскаток пишется в `/v1/deployments`.

Эта модель остаётся основной, пока размер парка и SLO укладываются в операционные ограничения.

## Проблема

При росте парка push-модель начинает упираться в:
- длительные окна раскатки;
- зависимость от доступности CI runner и SSH-коннективности до всех хостов;
- повышенную стоимость массовых ретраев;
- риск дрейфа, когда часть хостов не дошла до целевого ref.

## Решение (на следующий срез)

Ввести pull-агент на data-plane хостах и перейти к hybrid-модели:
- control-plane публикует целевой `release_ref` через `GET /v1/release/latest`;
- pull-агент периодически запрашивает target ref и сравнивает с локальным;
- при расхождении агент запускает локальный безопасный upgrade-процедурный шаг;
- результат фиксируется в heartbeat и аудит-канале deployments.

Push-пайплайн не удаляется сразу: остаётся как emergency/override путь.

## Триггеры перехода push -> hybrid/pull

Пересмотр обязателен при достижении хотя бы одного условия:
- активных data-plane хостов больше 20;
- p95 времени полного release-цикла стабильно выше 60 минут;
- доля частичных rollout (`not all hosts updated`) выше 2% за 30 дней;
- среднее время восстановления после массового сетевого сбоя выше целевого SLO.

## Минимальный дизайн pull-агента

1. **Планировщик**
   - systemd timer, интервал 1-5 минут с jitter.
2. **Источник истины**
   - `GET /v1/release/latest` (ref + contract_version + published_at).
3. **Доверие и целостность**
   - токен сервера (`SERVER_TOKEN`) для auth;
   - подпись артефакта/референса (или allowlist commit/tag policy);
   - запрет downgrade без явного control-plane флага.
4. **Применение**
   - atomical deploy тем же принципом `releases/<id> + current symlink`;
   - повторное использование проверок `app:custom:doctor` и `app:custom:check-compat`.
5. **Backoff и безопасность**
   - exponential backoff при сетевых ошибках;
   - rate limit на повторные попытки;
   - circuit-breaker при повторяющемся fail.
6. **Наблюдаемость**
   - heartbeat содержит `core_ref`, `target_ref`, `last_pull_status`, `last_pull_at`;
   - deployments-аудит фиксирует `initiator=pull-agent`.

## План миграции без downtime

1. Подготовить pull-агент как opt-in на canary-хостах.
2. Ввести hybrid режим:
   - push обновляет `target_ref` в control-plane;
   - pull-агенты догоняют хосты самостоятельно.
3. Подтвердить метрики на canary/bake.
4. Расширить на production по owner-группам.
5. Оставить push как аварийный канал (`hotfix.yml`).
6. Через 1-2 релизных цикла пересмотреть необходимость полного отказа от push.

## Риски и контрмеры

- **Split-brain target state**: один источник истины только в control-plane.
- **Непроверенные артефакты**: обязательная верификация ref/signature.
- **Шторм запросов**: jitter + backoff + лимиты.
- **Сложность отладки**: унифицированные статусы в heartbeat/deployments.

## Что не делаем в этой итерации

- не внедряем pull-агент в production;
- не меняем текущий `release.yml` контракт;
- не убираем push-пайплайн из CI.
