<?php

declare(strict_types=1);

$root = dirname(__DIR__);

$checks = [
    [
        'name' => 'license.v1.json',
        'schema' => $root . '/schemas/license.v1.json',
        'fixture' => $root . '/tools/fixtures/license.sample.json',
        'required' => ['tarif', 'features', 'status', 'valid_until'],
    ],
    [
        'name' => 'register.v1.json',
        'schema' => $root . '/schemas/register.v1.json',
        'fixture' => $root . '/tools/fixtures/register.sample.json',
        'required' => ['request', 'response'],
    ],
    [
        'name' => 'heartbeat.v1.json',
        'schema' => $root . '/schemas/heartbeat.v1.json',
        'fixture' => $root . '/tools/fixtures/heartbeat.sample.json',
        'required' => ['request', 'response'],
    ],
    [
        'name' => 'release.v1.json',
        'schema' => $root . '/schemas/release.v1.json',
        'fixture' => $root . '/tools/fixtures/release.sample.json',
        'required' => ['request', 'response'],
    ],
];

foreach ($checks as $check) {
    $schema = decodeJsonFile($check['schema']);
    $fixture = decodeJsonFile($check['fixture']);

    if (!is_array($schema) || !is_array($fixture)) {
        fail('Схема или фикстура не являются JSON-объектом: ' . $check['name']);
    }

    foreach ($check['required'] as $requiredKey) {
        if (!array_key_exists($requiredKey, $fixture)) {
            fail(sprintf('Фикстура %s не содержит обязательный ключ "%s"', $check['name'], $requiredKey));
        }
    }
}

echo "Контракты проверены: OK\n";

/**
 * @return array<string, mixed>
 */
function decodeJsonFile(string $path): array
{
    if (!is_file($path)) {
        fail('Файл не найден: ' . $path);
    }

    $content = file_get_contents($path);
    if ($content === false) {
        fail('Не удалось прочитать файл: ' . $path);
    }

    try {
        /** @var mixed $decoded */
        $decoded = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException $exception) {
        fail('Невалидный JSON в файле ' . $path . ': ' . $exception->getMessage());
    }

    if (!is_array($decoded)) {
        fail('JSON должен быть объектом: ' . $path);
    }

    return $decoded;
}

function fail(string $message): never
{
    fwrite(STDERR, $message . PHP_EOL);
    exit(1);
}

